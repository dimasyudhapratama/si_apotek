<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use App\ReturnPenjualan;

class LaporanReturnPenjualanController extends Controller
{
    //Halaman Index
    function index(){
        return view('modules/report/laporan_return_penjualan/v_report');
    }

    public function json(Request $request){
        //Initalization 
        $data = "";

        if($request->tipe_pencarian == "0" && $request->status_pembayaran == "0"){ //Menampilkan Semua Data Tanpa Filter
            $data = DB::table('return_penjualan')
            ->join('penjualan','return_penjualan.penjualan_id','=','penjualan.id')
            ->leftJoin('users','return_penjualan.user_id','=','users.id')
            ->leftJoin('dokter','penjualan.dokter_id','=', 'dokter.id')
            ->leftJoin('customers','penjualan.customer_id','=', 'customers.id')
            ->select('return_penjualan.id','return_penjualan.penjualan_id','return_penjualan.created_at','users.name','dokter.nama AS nama_dokter','customers.nama AS nama_customer','return_penjualan.status_pembayaran','return_penjualan.grand_total')
            ->get();
        }else if($request->tipe_pencarian == "0" && $request->status_pembayaran<> "0"){ //menampilkan Data Dengan tidak memfilter Tipe Pencarian dan  Dengan filter Tipe Pembayaran Lunas / Belum Lunas
            $data = DB::table('return_penjualan')
            ->join('penjualan','return_penjualan.penjualan_id','=','penjualan.id')
            ->leftJoin('users','return_penjualan.user_id','=','users.id')
            ->leftJoin('dokter','penjualan.dokter_id','=', 'dokter.id')
            ->leftJoin('customers','penjualan.customer_id','=', 'customers.id')
            ->select('return_penjualan.id','return_penjualan.penjualan_id','return_penjualan.created_at','users.name','dokter.nama AS nama_dokter','customers.nama AS nama_customer','return_penjualan.status_pembayaran','return_penjualan.grand_total')
            ->where('return_penjualan.status_pembayaran','=',$request->status_pembayaran)
            ->get();
        }else if($request->tipe_pencarian <> "0" && $request->status_pembayaran == "0"){ //Menampilkan Data Dengan Tipe Pencarian dan tidak memfilter Status Pembayaran 
            if($request->tipe_pencarian == "1"){
                $data = DB::table('return_penjualan')
                ->join('penjualan','return_penjualan.penjualan_id','=','penjualan.id')
                ->leftJoin('users','return_penjualan.user_id','=','users.id')
                ->leftJoin('dokter','penjualan.dokter_id','=', 'dokter.id')
                ->leftJoin('customers','penjualan.customer_id','=', 'customers.id')
                ->select('return_penjualan.id','return_penjualan.penjualan_id','return_penjualan.created_at','users.name','dokter.nama AS nama_dokter','customers.nama AS nama_customer','return_penjualan.status_pembayaran','return_penjualan.grand_total')
                ->whereMonth('return_penjualan.created_at',$request->bulan)
                ->whereYear('return_penjualan.created_at',$request->tahun)
                ->get();
            }else if($request->tipe_pencarian == "2"){
                $data = DB::table('return_penjualan')
                ->join('penjualan','return_penjualan.penjualan_id','=','penjualan.id')
                ->leftJoin('users','return_penjualan.user_id','=','users.id')
                ->leftJoin('dokter','penjualan.dokter_id','=', 'dokter.id')
                ->leftJoin('customers','penjualan.customer_id','=', 'customers.id')
                ->selct('return_penjualan.id','return_penjualan.penjualan_id','return_penjualan.created_at','users.name','dokter.nama AS nama_dokter','customers.nama AS nama_customer','return_penjualan.status_pembayaran','return_penjualan.grand_total')
                ->whereMonth('return_penjualan.created_at',$request->bulan)
                ->whereYear('return_penjualan.created_at',$request->tahun)
                ->get();
            }else if($request->tipe_pencarian == "3"){
                $data = DB::table('return_penjualan')
                ->join('penjualan','return_penjualan.penjualan_id','=','penjualan.id')
                ->leftJoin('users','return_penjualan.user_id','=','users.id')
                ->leftJoin('dokter','penjualan.dokter_id','=', 'dokter.id')
                ->leftJoin('customers','penjualan.customer_id','=', 'customers.id')
                ->select('return_penjualan.id','return_penjualan.penjualan_id','return_penjualan.created_at','users.name','dokter.nama AS nama_dokter','customers.nama AS nama_customer','return_penjualan.status_pembayaran','return_penjualan.grand_total')
                ->whereYear('return_penjualan.created_at',$request->tahun)
                ->get();
            }else if($request->tipe_pencarian == "4"){
                $data = DB::table('return_penjualan')
                ->join('penjualan','return_penjualan.penjualan_id','=','penjualan.id')
                ->leftJoin('users','return_penjualan.user_id','=','users.id')
                ->leftJoin('dokter','penjualan.dokter_id','=', 'dokter.id')
                ->leftJoin('customers','penjualan.customer_id','=', 'customers.id')
                ->select('return_penjualan.id','return_penjualan.penjualan_id','return_penjualan.created_at','users.name','dokter.nama AS nama_dokter','customers.nama AS nama_customer','return_penjualan.status_pembayaran','return_penjualan.grand_total')
                ->whereBetween('return_penjualan.created_at', [$request->tanggal_awal, $request->tanggal_akhir])
                ->get();
            }
        }else if($request->tipe_pencarian <> "0" && $request->status_pembayaran <> "0"){ //Memfilter Seluruh Data
            if($request->tipe_pencarian == "1"){
                $data = DB::table('return_penjualan')
                ->join('penjualan','return_penjualan.penjualan_id','=','penjualan.id')
                ->leftJoin('users','return_penjualan.user_id','=','users.id')
                ->leftJoin('dokter','penjualan.dokter_id','=', 'dokter.id')
                ->leftJoin('customers','penjualan.customer_id','=', 'customers.id')
                ->select('return_penjualan.id','return_penjualan.penjualan_id','return_penjualan.created_at','users.name','dokter.nama AS nama_dokter','customers.nama AS nama_customer','return_penjualan.status_pembayaran','return_penjualan.grand_total')
                ->whereMonth('return_penjualan.created_at',$request->bulan)
                ->whereYear('return_penjualan.created_at',$request->tahun)
                ->where('return_penjualan.status_pembayaran','=',$request->status_pembayaran)
                ->get();
            }else if($request->tipe_pencarian == "2"){
                $data = DB::table('return_penjualan')
                ->join('penjualan','return_penjualan.penjualan_id','=','penjualan.id')
                ->leftJoin('users','return_penjualan.user_id','=','users.id')
                ->leftJoin('dokter','penjualan.dokter_id','=', 'dokter.id')
                ->leftJoin('customers','penjualan.customer_id','=', 'customers.id')
                ->select('return_penjualan.id','return_penjualan.penjualan_id','return_penjualan.created_at','users.name','dokter.nama AS nama_dokter','customers.nama AS nama_customer','return_penjualan.status_pembayaran','return_penjualan.grand_total')
                ->whereMonth('return_penjualan.created_at',$request->bulan)
                ->whereYear('return_penjualan.created_at',$request->tahun)
                ->where('return_penjualan.status_pembayaran','=',$request->status_pembayaran)
                ->get();
            }else if($request->tipe_pencarian == "3"){
                $data = DB::table('return_penjualan')
                ->join('penjualan','return_penjualan.penjualan_id','=','penjualan.id')
                ->leftJoin('users','return_penjualan.user_id','=','users.id')
                ->leftJoin('dokter','penjualan.dokter_id','=', 'dokter.id')
                ->leftJoin('customers','penjualan.customer_id','=', 'customers.id')
                ->select('return_penjualan.id','return_penjualan.penjualan_id','return_penjualan.created_at','users.name','dokter.nama AS nama_dokter','customers.nama AS nama_customer','return_penjualan.status_pembayaran','return_penjualan.grand_total')
                ->whereYear('return_penjualan.created_at',$request->tahun)
                ->where('return_penjualan.status_pembayaran','=',$request->status_pembayaran)
                ->get();
            }else if($request->tipe_pencarian == "4"){
                $data = DB::table('return_penjualan')
                ->join('penjualan','return_penjualan.penjualan_id','=','penjualan.id')
                ->leftJoin('users','return_penjualan.user_id','=','users.id')
                ->leftJoin('dokter','penjualan.dokter_id','=', 'dokter.id')
                ->leftJoin('customers','penjualan.customer_id','=', 'customers.id')
                ->select('return_penjualan.id','return_penjualan.penjualan_id','return_penjualan.created_at','users.name','dokter.nama AS nama_dokter','customers.nama AS nama_customer','return_penjualan.status_pembayaran','return_penjualan.grand_total')
                ->whereBetween('return_penjualan.created_at', [$request->tanggal_awal, $request->tanggal_akhir])
                ->where('return_penjualan.status_pembayaran','=',$request->status_pembayaran)
                ->get();
            }
        }
        
        return datatables()->of($data)->toJson();
    }

    //Halaman Detail Detail Laporan Penjualan
    function detail($id){
        //Data Record Return Penjualan
        $master_data = DB::table('return_penjualan')
        ->join('penjualan','return_penjualan.penjualan_id','=','penjualan.id')
        ->leftJoin('users','return_penjualan.user_id','=','users.id')
        ->leftJoin('dokter','penjualan.dokter_id','=', 'dokter.id')
        ->leftJoin('customers','penjualan.customer_id','=', 'customers.id')
        ->where('return_penjualan.id','=',$id)
        ->select('return_penjualan.id','return_penjualan.penjualan_id','return_penjualan.created_at','users.name AS nama_user','tipe_penjualan','dokter.nama AS nama_dokter','customers.nama AS nama_customer',
            'return_penjualan.status_pembayaran','return_penjualan.total','return_penjualan.diskon','return_penjualan.grand_total','return_penjualan.terbayar','return_penjualan.sisa_tunggakan')    
        ->first();

        // Data Record Detail Penjualan
        $detail_data = DB::table('detail_return_penjualan')
        ->join('produk_konversi_stok','detail_return_penjualan.produk_konversi_stok_id','=','produk_konversi_stok.id')
        ->join('produk','produk_konversi_stok.produk_id','=','produk.id')
        ->where('return_penjualan_id','=',$id)
        ->select('detail_return_penjualan.id','produk_konversi_stok.produk_id','produk.nama_produk','produk_konversi_stok.satuan','harga','qty','subtotal')
        ->get();
        
        $data = [
            'master_data' => $master_data,
            'detail_data' => $detail_data,
        ];
        return view('modules/report/laporan_return_penjualan/v_detail',$data);
    }

    //Data Ajax Pembayaran Return Penjualan Untuk Halaman Detail Laporan Return Penjualan
    function pembayaran($id){
        $pembayaran = DB::table('pembayaran_return_penjualan')
        ->where('return_penjualan_id','=',$id)
        ->select('id','jumlah','created_at')
        ->get();

        return datatables()->of($pembayaran)->toJson();
    }
}
