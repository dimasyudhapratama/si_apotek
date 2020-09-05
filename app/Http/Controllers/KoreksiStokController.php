<?php

namespace App\Http\Controllers;

use Illuminate\Support\Facades\Auth;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use App\KoreksiStok;
use App\DetailkoreksiStok;
use App\ProdukStokDetail;

class KoreksiStokController extends Controller
{
    function index(){
        return view('modules/koreksi_stok/v_transaksi');
    }

    function produk($id){
        $data_from_db = DB::table('produk')
        ->select('nama_produk')
        ->where('id','=',$id)
        ->get();
        return $data_from_db;
    }

    function produkNonExpired($id){
        $data_from_db = DB::table('produk_stok_detail')
        ->join('produk_konversi_stok','produk_stok_detail.produk_konversi_stok_id','=','produk_konversi_stok.id')
        ->where('produk_konversi_stok.produk_id','=',$id)
        ->where('jumlah','>',0)
        ->select('exp_date')
        ->distinct('exp_date')
        ->get();
        return $data_from_db;
    }

    function satuanProduk(Request $request){
        //Data From Client
        $id = $request->id;
        $exp_date = $request->exp_date;
        $tipe_penjualan = $request->tipe_penjualan;

        $data_from_db = DB::table('produk_konversi_stok')
        ->join('produk_stok_detail','produk_stok_detail.produk_konversi_stok_id','=','produk_konversi_stok.id')
        ->where('produk_konversi_stok.produk_id','=',$id)
        ->where('produk_stok_detail.exp_date','=',$exp_date)
        ->select('produk_konversi_stok.id','satuan','jumlah')
        ->get();
        return $data_from_db;
    }

    function store(Request $request){
        //Save Ke Tabel Koreksi Stok
        $array_data = [
            'user_id' => Auth::id(), 
            'keterangan' => $request->keterangan
        ];
        $koreksi_stok = KoreksiStok::create($array_data);

        for($i=0; $i< count($request->kode_produk); $i++){
            //Pengolahan Stok
            //Detail Konversi Stok Per Row - Mengambil Level Stok
            $produk_konversi_stok = DB::table('produk_konversi_stok')->where('id',$request->satuan[$i])->select('level')->first();
            $level_satuan_initial = $produk_konversi_stok->level;


            //load Konversi Stok
            $produk_konversi_stok_data = DB::table('produk_konversi_stok')  //Looping Per Row Berdasarkan Produk ID dan Status Aktif 1
            ->join('produk','produk.id','=','produk_konversi_stok.produk_id')
            ->where('produk_konversi_stok.produk_id','=',$request->kode_produk[$i])
            ->where('produk_konversi_stok.status_aktif','=','1')
            ->select('produk.level_satuan','produk_konversi_stok.id AS produk_konversi_stok_id','produk_konversi_stok.level','produk_konversi_stok.nilai_konversi')
            ->orderByDesc('produk_konversi_stok_id')
            ->get();

            $increment_temporary = 0;
            $nilai_konversi = 1;
            $input_stok = 0;
            $stok_baru = 0;
            foreach($produk_konversi_stok_data as $p){
                
                //Increment Temporary Digunakan untuk Percabangan Multi Stok
                if($increment_temporary == 0){
                    //Nilai Konversi
                    $nilai_konversi = $p->nilai_konversi;

                    //Jika Level Satuan Barang Yang Diinput adalah level 1
                    if($level_satuan_initial == 1){
                        $input_stok = $request->qty[$i] * $nilai_konversi;

                    }else if($level_satuan_initial == 2){ //Jika Level Satuan Barang yang diinput adalah level 2
                        $input_stok = $request->qty[$i] * 1;
                    }


                    //Mencari Stok Lama Di Database
                    $stok_lama = 0;
                    if(DB::table('produk_stok_detail')
                        ->where('produk_konversi_stok_id',$p->produk_konversi_stok_id)
                        ->where('exp_date',$request->exp_date[$i])
                        ->exists()){

                        $data = DB::table('produk_stok_detail')->where('produk_konversi_stok_id',$p->produk_konversi_stok_id)->where('exp_date',$request->exp_date[$i])->first();
                        $stok_lama = $data->jumlah;
                    }

                    //Stok Baru adalah Input Stok
                    $stok_baru = $input_stok;

                    ////Save Ke Tabel Detail Koreksi Stok
                    //Input Hanya Dilakukan Sekali
                    //Contoh ada 2 Level Satuan, yaitu Kardus dan Botol. User melakukan perubahan pada Level Kardus,
                    //Maka cukup diinput 1 level saja (Level Terakhir yaitu Botol) ke tabel Detail Koreksi Stok
                    $array_data_detail = [
                        'koreksi_stok_id' => $koreksi_stok->id,
                        'produk_konversi_stok_id' => $p->produk_konversi_stok_id,
                        'produk_stok_detail_exp_date' => $request->exp_date[$i],
                        'qty_awal' => $stok_lama,
                        'qty_akhir' => $stok_baru
                    ];
                    DetailKoreksiStok::create($array_data_detail);

                }else if($increment_temporary == 1){
                    $stok_baru = $stok_baru / $nilai_konversi;
                }

                //Increment Temporary
                $increment_temporary++;

                //Update or create New Data on Produk Stok Detail Table
                $where = [
                    'produk_konversi_stok_id' => $p->produk_konversi_stok_id,
                    'exp_date' => $request->exp_date[$i],
                ];                
                $data_detail_stok = [
                    'produk_konversi_stok_id' => $p->produk_konversi_stok_id,
                    'exp_date' => $request->exp_date[$i],
                    'jumlah' => $stok_baru,
                ];
                ProdukStokDetail::updateOrCreate($where, $data_detail_stok);
                
            }

            //Return Ajax
            $return_data = [
                'status' => 'success',
                'invoice_number' => $koreksi_stok->id

            ];
            return $return_data;
            

            
        }
    }

}
