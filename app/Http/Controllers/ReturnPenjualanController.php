<?php

namespace App\Http\Controllers;

use Illuminate\Support\Facades\Auth;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

use App\ReturnPenjualan;
use App\DetailReturnPenjualan;
use App\PembayaranReturnPenjualan;
use App\ProdukStokDetail;

class ReturnPenjualanController extends Controller
{
    function index(){
        return view('modules/return_penjualan/v_transaksi');
    }

    function getDataPenjualanByPenjualanId($penjualan_id){
        //Mencari Data Penjualan Berdasarkan Field Penjualan_ID
        $data_penjualan = DB::table('penjualan')
        ->leftJoin('users','penjualan.user_id','=','users.id')
        ->leftJoin('dokter','penjualan.dokter_id','=','dokter.id')
        ->leftJoin('customers','penjualan.customer_id','=','customers.id')
        ->where('penjualan.id','=',$penjualan_id)
        ->select('penjualan.id','tipe_penjualan','dokter.nama AS nama_dokter','customers.nama AS nama_customer','cara_pembayaran','tgl_jatuh_tempo','status_pembayaran','total','diskon','grand_total','terbayar','sisa_tunggakan');
        
        //Jika Data Ditemukan, Maka diproses lebih lanjut
        if($data_penjualan->count() > 0){

            //Mencari Detail Item Yang Terjual
            $detail_penjualan = DB::table('detail_penjualan')
            ->join('produk_konversi_stok','detail_penjualan.produk_konversi_stok_id','=','produk_konversi_stok.id')
            ->join('produk','produk_konversi_stok.produk_id','=','produk.id')
            ->where('penjualan_id','=',$penjualan_id)
            ->select('detail_penjualan.id','produk_konversi_stok.produk_id','produk.nama_produk','detail_penjualan.produk_konversi_stok_id','detail_penjualan.produk_stok_detail_exp_date' ,'produk_konversi_stok.satuan','harga','qty','subtotal')
            ->get();

            //Array Yang dikirim ke frontend
            $data_return_to_frontend = array(
                'status' => 'success',
                'master_penjualan' => $data_penjualan->first(),
                'detail_penjualan' => $detail_penjualan
            );

        }else{
            //Array Yang dikirim ke frontend jika gagal
            $data_return_to_frontend = array(
                'status' => 'failed'
            );
        }

        return $data_return_to_frontend;
    }

    function store(Request $request){
        //Save Ke Tabel Return Penjualan
        $array_data = [
            'user_id' => Auth::id(), 
            'penjualan_id' => $request->penjualan_id,
            'status_pembayaran' => $request->terbayar >= $request->grand_total ? "1" : "0",
            'total' => $request->total,
            'diskon' => $request->diskon,
            'grand_total' => $request->grand_total,
            'terbayar' => $request->terbayar >= $request->grand_total ? $request->grand_total : $request->terbayar,
            'sisa_tunggakan' => $request->terbayar >= $request->grand_total ? 0 : $request->grand_total - $request->terbayar,
            //Untuk Struk
            'uang_pembayaran' => $request->terbayar,
            'kembalian_pembayaran' => $request->terbayar >= $request->grand_total ? $request->terbayar - $request->grand_total : 0,
        ];

        $return_penjualan = ReturnPenjualan::create($array_data);

        //Insert Ke Tabel Pembayaran Return Penjualan
        if($request->terbayar > 0){
            $array_data_pembayaran = [
                'return_penjualan_id' => $return_penjualan->id,
                'jumlah' => $request->terbayar - $request->grand_total >= 0 ? $request->grand_total : $request->terbayar,
                'user_id' => Auth::id()
            ];
            PembayaranReturnPenjualan::create($array_data_pembayaran);
        }
        

        //Detail Return Penjualan
        for($i = 0; $i < count($request->subtotal); $i++){
            //Save Ke Tabel Detail Retur Penjualan
            $array_data_detail = [
                'return_penjualan_id' => $return_penjualan->id,
                'produk_konversi_stok_id' => $request->satuan[$i], //Mewakili Produk Konversi Stok ID - Diambil dari 
                'produk_stok_detail_exp_date' => $request->exp_date[$i],
                'harga' => $request->harga[$i],
                'qty' => $request->qty[$i],
                'subtotal' => $request->subtotal[$i],
            ];
            DetailReturnPenjualan::create($array_data_detail);


            //Pengolahan Stok
            //Detail Konversi Stok Per Row - Mengambil Level Stok
            $produk_konversi_stok_row = DB::table('produk_konversi_stok')->where('id',$request->satuan[$i])->select('level')->first();
            $level_satuan_initial = $produk_konversi_stok_row->level;


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

                    //Menjumlahkan Stok Lama dengan Input Stok
                    $stok_baru = $stok_lama + $input_stok;

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

        }

        //Return Ajax
        $return_data = [
            'status' => 'success',
            'invoice_number' => $return_penjualan->id

        ];
        return $return_data ;
    }
    

    function simpanPembayaranReturnPenjualan(Request $request){
        $data = [
            'return_penjualan_id' => $request->return_penjualan_id,
            'user_id' => Auth::id(),
            'jumlah' => $request->data_pembayaran_jumlah
        ];
        PembayaranReturnPenjualan::create($data);
        $return_penjualan = ReturnPenjualan::find($request->return_penjualan_id);
        if($return_penjualan->grand_total - $return_penjualan->terbayar <= 0){
            $return_penjualan->status_pembayaran = 1;
        }
        $return_penjualan->terbayar += $request->data_pembayaran_jumlah;
        $return_penjualan->save();
        return $return_penjualan;
    }
}
