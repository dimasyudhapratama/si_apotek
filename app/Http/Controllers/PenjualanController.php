<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use App\Dokter;
use App\Customer;
use App\Penjualan;
use App\PembayaranPenjualan;
use App\DetailPenjualan;

class PenjualanController extends Controller{

    function index(){
        //Mengambil Data Dokter dari Database
        $dokter = Dokter::get();        

        //Menampilkan View dengan menampilkan data Dokter
        return view('modules/penjualan/v_transaksi',['dokter' => $dokter]);
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

    function hargaProduk(Request $request){
        //Data From Client
        $id = $request->id;
        $tipe_penjualan = $request->tipe_penjualan;

        $data_from_db = "";
        if($tipe_penjualan == "Biasa"){
            $data_from_db = DB::table('produk_konversi_stok')
            ->select('harga_biasa AS harga')
            ->where('id','=',$id)
            ->get();
        }else if($tipe_penjualan == "Resep"){
            $data_from_db = DB::table('produk_konversi_stok')
            ->select('harga_resep AS harga')
            ->where('id','=',$id)
            ->get();
        }
        return $data_from_db;
    }

    function store(Request $request){
        //Save Ke Tabel Penjualan
        $array_data = [
            'user_id' => "1", 
            'dokter_id' => $request->dokter,
            'customer_id' => $request->customer,
            'tipe_penjualan' => $request->tipe_penjualan,
            'cara_pembayaran' => $request->cara_pembayaran, 
            'tgl_jatuh_tempo' => $request->jatuh_tempo,
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

        $penjualan = Penjualan::create($array_data);

        //Insert Ke Tabel Pembayaran Penjualan
        $array_data_kredit = [
            'penjualan_id' => $penjualan->id,
            'jumlah' => $request->terbayar - $request->grand_total >= 0 ? $request->grand_total : $request->terbayar,
            'user_id' => "1"
        ];
        PembayaranPenjualan::create($array_data_kredit);
        

        //Detail Pembelian
        for($i = 0; $i < count($request->subtotal); $i++){
            //Save Ke Tabel Detail Pembelian
            $array_data_detail = [
                'penjualan_id' => $penjualan->id,
                'produk_konversi_stok_id' => $request->satuan[$i],
                'produk_stok_detail_exp_date' => $request->exp_date[$i],
                'harga' => $request->harga[$i],
                'qty' => $request->qty[$i],
                'subtotal' => $request->subtotal[$i],
            ];
            DetailPenjualan::create($array_data_detail);


            // //Pengolahan Stok
            // //Detail Konversi Stok Per Row - Mengambil Level Stok
            // $detail_pembelian = DB::table('produk_konversi_stok')->where('id',$request->satuan[$i])->select('level')->first();
            // $level = $detail_pembelian->level;


            // //load Konversi Stok
            // $produk_konversi_stok_data = DB::table('produk_konversi_stok')  //Looping Per Row Berdasarkan Produk ID dan Status Aktif 1
            // ->join('produk','produk.id','=','produk_konversi_stok.produk_id')
            // ->where('produk_konversi_stok.produk_id','=',$request->kode_produk[$i])
            // ->where('produk_konversi_stok.level','>=',$level)
            // ->where('produk_konversi_stok.status_aktif','=','1')
            // ->select('produk.level_satuan','produk_konversi_stok.id AS produk_konversi_stok_id','produk_konversi_stok.level','produk_konversi_stok.nilai_konversi')
            // ->get();
            
            // // $jumlah_konversi_temp = 1; // Stok Konversi Pertama adalah 0
            // $temp = 1;
            // $nilai_konversi = 1;
            // $level_initial = 1;
            // foreach($produk_konversi_stok_data as $p){
            //     if($level_initial > 1){
            //         $temp = $p->nilai_konversi / $temp;
            //         $nilai_konversi *= $temp;

            //     }
            //     // echo $temp.' '.$nilai_konversi.'<br>';
                
            //     // Melihat di Tabel Produk Stok Detail Berdasarkan 
            //     $jumlah_awal = 0;
            //     $jumlah_baru = $request->qty[$i] * $nilai_konversi;

            //     if(DB::table('produk_stok_detail')->where('produk_konversi_stok_id',$p->produk_konversi_stok_id)->where('exp_date',$request->exp_date[$i])->exists()){
            //         $data = DB::table('produk_stok_detail')->where('produk_konversi_stok_id',$p->produk_konversi_stok_id)->where('exp_date',$request->exp_date[$i])->first();
            //         $jumlah_awal = $data->jumlah;
            //     }

            //     $where = [
            //         'produk_konversi_stok_id' => $p->produk_konversi_stok_id,
            //         'exp_date' => $request->exp_date[$i],
            //     ];                
            //     $data_detail_stok = [
            //         'produk_konversi_stok_id' => $p->produk_konversi_stok_id,
            //         'exp_date' => $request->exp_date[$i],
            //         'jumlah' => $jumlah_awal + $jumlah_baru,
            //     ];
            //     ProdukStokDetail::updateOrCreate($where, $data_detail_stok);
             
            //     $temp = $p->nilai_konversi;
            //     $level_initial++;
            // }
        }
        //Return Ajax
        $return_data = [
            'status' => 'success',
            'invoice_number' => $penjualan->id

        ];
        return $return_data ;
    }

    function simpanPembayaranPenjualan(Request $request){
        $data = [
            'penjualan_id' => $request->penjualan_id,
            'jumlah' => $request->data_pembayaran_jumlah,
            'user_id' => 1
        ];
        PembayaranPenjualan::create($data);

        $penjualan = Penjualan::find($request->penjualan_id);
        if($penjualan->grand_total - $penjualan->terbayar <= 0){
            $penjualan->status_pembayaran = 1;
        }
        $penjualan->terbayar += $request->data_pembayaran_jumlah;
        $penjualan->save();
        return $penjualan;
    }

    function struk58($id){
        $master_penjualan_data = DB::table('penjualan')
        ->leftJoin('dokter','penjualan.dokter_id','=','dokter.id')
        ->leftJoin('customers','penjualan.customer_id','=','customers.id')
        ->select('penjualan.id','dokter.nama AS nama_dokter','customers.nama AS nama_customer','created_at','total','diskon','grand_total','uang_pembayaran','kembalian_pembayaran')
        ->where('penjualan.id','=',$id);

        if($master_penjualan_data->count() == 0){
            return abort(404);
        }else{
            $master_penjualan = $master_penjualan_data->first();
        }

        //Data Detail Penjualan
        $detail_penjualan = DB::table('detail_penjualan')
        ->join('produk_konversi_stok','detail_penjualan.produk_konversi_stok_id','=','produk_konversi_stok.id')
        ->join('produk','produk_konversi_stok.produk_id','=','produk.id')
        ->where('penjualan_id','=',$id)
        ->select('produk.nama_produk','harga','qty','subtotal')
        ->get();
        return view('modules/penjualan/struk_transaksi_58',['master_penjualan' => $master_penjualan, 'detail_penjualan' => $detail_penjualan]);
    }
}
