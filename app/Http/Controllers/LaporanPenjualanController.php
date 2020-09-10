<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use App\Penjualan;

class LaporanPenjualanController extends Controller
{
    function index(){
        return view('modules/report/laporan_penjualan/v_report');
    }

    public function json(Request $request){
        //Initalization 
        $data = DB::table('penjualan')
            ->leftJoin('users','penjualan.user_id','=','users.id')
            ->leftJoin('dokter','penjualan.dokter_id','=', 'dokter.id')
            ->leftJoin('customers','penjualan.customer_id','=', 'customers.id')
            ->select('penjualan.id','penjualan.created_at','users.name','dokter.nama AS nama_dokter','customers.nama AS nama_customer','cara_pembayaran','tgl_jatuh_tempo','status_pembayaran','grand_total');

        
        if($request->tipe_pencarian <> "0"){ //Menampilkan Data Dengan Tipe Pencarian 
            if($request->tipe_pencarian == "1"){
                $date = $request->tahun.'-'.$request->bulan.'-'.$request->tanggal;
                $data->whereDate('penjualan.created_at',$date);

            }else if($request->tipe_pencarian == "2"){
                $data->whereMonth('penjualan.created_at',$request->bulan)
                ->whereYear('penjualan.created_at',$request->tahun);

            }else if($request->tipe_pencarian == "3"){
                $data->whereYear('penjualan.created_at',$request->tahun);

            }else if($request->tipe_pencarian == "4"){
                $data->whereBetween('penjualan.created_at', [$request->tanggal_awal, $request->tanggal_akhir]);
            }
        }
        
        return datatables()->of($data->get())->toJson();
    }

    //Halaman Detail Detail Laporan Penjualan
    function detail($id){
        //Data Penjualan
        $data_penjualan = DB::table('penjualan')
        ->leftJoin('users','penjualan.user_id','=','users.id')
        ->leftJoin('dokter','penjualan.dokter_id','=','dokter.id')
        ->leftJoin('customers','penjualan.customer_id','=','customers.id')
        ->where('penjualan.id','=',$id)
        ->select('penjualan.id','penjualan.created_at','users.name AS nama_user','tipe_penjualan','dokter.nama AS nama_dokter','customers.nama AS nama_customer','cara_pembayaran','tgl_jatuh_tempo','status_pembayaran','total','diskon','grand_total','terbayar','sisa_tunggakan')
        ->first();

        //Data Detail Penjualan
        $detail = DB::table('detail_penjualan')
        ->join('produk_konversi_stok','detail_penjualan.produk_konversi_stok_id','=','produk_konversi_stok.id')
        ->join('produk','produk_konversi_stok.produk_id','=','produk.id')
        ->where('penjualan_id','=',$id)
        ->select('detail_penjualan.id','produk_konversi_stok.produk_id','produk.nama_produk','produk_konversi_stok.satuan','harga','qty','subtotal')
        ->get();
        
        $data = [
            'data_penjualan' => $data_penjualan,
            'detail' => $detail,
        ];
        return view('modules/report/laporan_penjualan/v_detail',$data);
    }

    //Data Ajax Pembayaran Penjualan Untuk Halaman Detail Laporan Penjualan
    function pembayaranPenjualan($id){
        $pembayaran = DB::table('pembayaran_penjualan')
        ->where('penjualan_id','=',$id)
        ->select('id','jumlah','created_at')
        ->get();

        return datatables()->of($pembayaran)->toJson();
    }
}
