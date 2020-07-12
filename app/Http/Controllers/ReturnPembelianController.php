<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

use App\ReturnPembelian;
use App\DetailReturnPembelian;
use App\PembayaranReturnPembelian;

class ReturnPembelianController extends Controller
{
    function index(){
        return view('modules/return_pembelian/v_transaksi');
    }

    function getDataPembelianByPembelianId($id){
        //Data Pembelian
        $data_pembelian = DB::table('pembelian')
        ->leftJoin('users','pembelian.user_id','=','users.id')
        ->leftJoin('supplier','pembelian.supplier_id','=', 'supplier.id')
        ->where('pembelian.id','=',$id)
        ->select('pembelian.id','pembelian.created_at','users.name AS nama_user','supplier.nama AS nama_supplier','cara_pembayaran','tgl_jatuh_tempo','status_pembayaran','total','diskon','grand_total','terbayar','sisa');
        
         //Jika Data Ditemukan, Maka diproses lebih lanjut
         if($data_pembelian->count() > 0){
            //Mencari Detail Item Yang Terjual
            //Data Detail Pembelian
            $detail = DB::table('detail_pembelian')
            ->join('produk_konversi_stok','detail_pembelian.produk_konversi_stok_id','=','produk_konversi_stok.id')
            ->join('produk','produk_konversi_stok.produk_id','=','produk.id')
            ->where('pembelian_id','=',$id)
            ->select('produk_konversi_stok.produk_id','produk.nama_produk','detail_pembelian.produk_konversi_stok_id','detail_pembelian.produk_stok_detail_exp_date','produk_konversi_stok.satuan','harga','qty','subtotal')
            ->get();

            $data_return_to_frontend = [
                'status' => 'success',
                'master' => $data_pembelian->first(),
                'detail' => $detail,
            ];

         }else{
             //Array Yang dikirim ke frontend jika gagal (Data Tidak Ditemukan)
            $data_return_to_frontend = array(
                'status' => 'failed'
            );
         }

         return $data_return_to_frontend;
    }

    function store(Request $request){
        //Save Ke Tabel Return Pembelian
        $array_data = [
            'user_id' => "1", 
            'pembelian_id' => $request->pembelian_id,
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

        $return_pembelian = ReturnPembelian::create($array_data);

        //Insert Ke Tabel Pembayaran Return Pembelian
        $array_data_kredit = [
            'return_pembelian_id' => $return_pembelian->id,
            'jumlah' => $request->terbayar - $request->grand_total >= 0 ? $request->grand_total : $request->terbayar,
            'user_id' => "1"
        ];
        PembayaranReturnPembelian::create($array_data_kredit);
        

        //Detail Return Pembelian
        for($i = 0; $i < count($request->subtotal); $i++){
            //Save Ke Tabel Detail Pembelian
            $array_data_detail = [
                'return_pembelian_id' => $return_pembelian->id,
                'produk_konversi_stok_id' => $request->satuan[$i],
                'produk_stok_detail_exp_date' => $request->exp_date[$i],
                'harga' => $request->harga[$i],
                'qty' => $request->qty[$i],
                'subtotal' => $request->subtotal[$i],
            ];
            DetailReturnPembelian::create($array_data_detail);


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
            'invoice_number' => $return_pembelian->id

        ];
        return $return_data ;
    }

    function simpanPembayaranReturnPembelian(Request $request){
        $data = [
            'return_pembelian_id' => $request->return_pembelian_id,
            'user_id' => 1,
            'jumlah' => $request->data_pembayaran_jumlah
        ];
        PembayaranReturnPembelian::create($data);

        $return_pembelian = ReturnPembelian::find($request->return_pembelian_id);
        if($return_pembelian->grand_total - $return_pembelian->terbayar <= 0){
            $return_pembelian->status_pembayaran = 1;
        }
        $return_pembelian->terbayar += $request->data_pembayaran_jumlah;
        $return_pembelian->save();
        return $return_pembelian;
    }
}
