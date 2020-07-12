<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use App\Pembelian;

class LaporanPembelianController extends Controller
{
    
    //Halaman Index
    function index(){
        return view('modules/report/laporan_pembelian/v_report');
    }

    //Datatables Halaman Index
    public function json(Request $request){
        //Initalization 
        $data = "";

        if($request->tipe_pencarian == "0" && $request->status_pembayaran == "0"){ //Menampilkan Semua Data Tanpa Filter
            $data = DB::table('pembelian')
            ->leftJoin('users','pembelian.user_id','=','users.id')
            ->leftJoin('supplier','pembelian.supplier_id','=', 'supplier.id')
            ->select('pembelian.id','pembelian.created_at','users.name','supplier.nama','cara_pembayaran','tgl_jatuh_tempo','status_pembayaran','grand_total')
            ->get();
        }else if($request->tipe_pencarian == "0" && $request->status_pembayaran<> "0"){ //menampilkan Data Dengan tidak memfilter Tipe Pencarian dan  Dengan filter Tipe Pembayaran Lunas / Belum Lunas
            $data = DB::table('pembelian')
            ->leftJoin('users','pembelian.user_id','=','users.id')
            ->leftJoin('supplier','pembelian.supplier_id','=', 'supplier.id')
            ->select('pembelian.id','pembelian.created_at','users.name','supplier.nama','cara_pembayaran','tgl_jatuh_tempo','status_pembayaran','grand_total')
            ->where('pembelian.status_pembayaran','=',$request->status_pembayaran)
            ->get();
        }else if($request->tipe_pencarian <> "0" && $request->status_pembayaran == "0"){ //Menampilkan Data Dengan Tipe Pencarian dan tidak memfilter Status Pembayaran 
            if($request->tipe_pencarian == "1"){
                $data = DB::table('pembelian')
                ->leftJoin('users','pembelian.user_id','=','users.id')
                ->leftJoin('supplier','pembelian.supplier_id','=', 'supplier.id')
                ->select('pembelian.id','pembelian.created_at','users.name','supplier.nama','cara_pembayaran','tgl_jatuh_tempo','status_pembayaran','grand_total')
                ->whereMonth('pembelian.created_at',$request->bulan)
                ->whereYear('pembelian.created_at',$request->tahun)
                ->get();
            }else if($request->tipe_pencarian == "2"){
                $data = DB::table('pembelian')
                ->leftJoin('users','pembelian.user_id','=','users.id')
                ->leftJoin('supplier','pembelian.supplier_id','=', 'supplier.id')
                ->select('pembelian.id','pembelian.created_at','users.name','supplier.nama','cara_pembayaran','tgl_jatuh_tempo','status_pembayaran','grand_total')
                ->whereMonth('pembelian.created_at',$request->bulan)
                ->whereYear('pembelian.created_at',$request->tahun)
                ->get();
            }else if($request->tipe_pencarian == "3"){
                $data = DB::table('pembelian')
                ->leftJoin('users','pembelian.user_id','=','users.id')
                ->leftJoin('supplier','pembelian.supplier_id','=', 'supplier.id')
                ->select('pembelian.id','pembelian.created_at','users.name','supplier.nama','cara_pembayaran','tgl_jatuh_tempo','status_pembayaran','grand_total')
                ->whereYear('pembelian.created_at',$request->tahun)
                ->get();
            }else if($request->tipe_pencarian == "4"){
                $data = DB::table('pembelian')
                ->leftJoin('users','pembelian.user_id','=','users.id')
                ->leftJoin('supplier','pembelian.supplier_id','=', 'supplier.id')
                ->select('pembelian.id','pembelian.created_at','users.name','supplier.nama','cara_pembayaran','tgl_jatuh_tempo','status_pembayaran','grand_total')
                ->whereBetween('pembelian.created_at', [$request->tanggal_awal, $request->tanggal_akhir])
                ->get();
            }
        }else if($request->tipe_pencarian <> "0" && $request->status_pembayaran <> "0"){ //Memfilter Seluruh Data
            if($request->tipe_pencarian == "1"){
                $data = DB::table('pembelian')
                ->leftJoin('users','pembelian.user_id','=','users.id')
                ->leftJoin('supplier','pembelian.supplier_id','=', 'supplier.id')
                ->select('pembelian.id','pembelian.created_at','users.name','supplier.nama','cara_pembayaran','tgl_jatuh_tempo','status_pembayaran','grand_total')
                ->whereMonth('pembelian.created_at',$request->bulan)
                ->whereYear('pembelian.created_at',$request->tahun)
                ->where('pembelian.status_pembayaran','=',$request->status_pembayaran)
                ->get();
            }else if($request->tipe_pencarian == "2"){
                $data = DB::table('pembelian')
                ->leftJoin('users','pembelian.user_id','=','users.id')
                ->leftJoin('supplier','pembelian.supplier_id','=', 'supplier.id')
                ->select('pembelian.id','pembelian.created_at','users.name','supplier.nama','cara_pembayaran','tgl_jatuh_tempo','status_pembayaran','grand_total')
                ->whereMonth('pembelian.created_at',$request->bulan)
                ->whereYear('pembelian.created_at',$request->tahun)
                ->where('pembelian.status_pembayaran','=',$request->status_pembayaran)
                ->get();
            }else if($request->tipe_pencarian == "3"){
                $data = DB::table('pembelian')
                ->leftJoin('users','pembelian.user_id','=','users.id')
                ->leftJoin('supplier','pembelian.supplier_id','=', 'supplier.id')
                ->select('pembelian.id','pembelian.created_at','users.name','supplier.nama','cara_pembayaran','tgl_jatuh_tempo','status_pembayaran','grand_total')
                ->whereYear('pembelian.created_at',$request->tahun)
                ->where('pembelian.status_pembayaran','=',$request->status_pembayaran)
                ->get();
            }else if($request->tipe_pencarian == "4"){
                $data = DB::table('pembelian')
                ->leftJoin('users','pembelian.user_id','=','users.id')
                ->leftJoin('supplier','pembelian.supplier_id','=', 'supplier.id')
                ->select('pembelian.id','pembelian.created_at','users.name','supplier.nama','cara_pembayaran','tgl_jatuh_tempo','status_pembayaran','grand_total')
                ->whereBetween('pembelian.created_at', [$request->tanggal_awal, $request->tanggal_akhir])
                ->where('pembelian.status_pembayaran','=',$request->status_pembayaran)
                ->get();
            }
        }
        
        return datatables()->of($data)->toJson();
    }

    //Halaman Detail Detail Laporan Pembelian
    function detail($id){
        //Data Pembelian
        $data_pembelian = DB::table('pembelian')
        ->leftJoin('users','pembelian.user_id','=','users.id')
        ->leftJoin('supplier','pembelian.supplier_id','=', 'supplier.id')
        ->where('pembelian.id','=',$id)
        ->select('pembelian.id','pembelian.created_at','users.name AS nama_user','supplier.nama AS nama_supplier','cara_pembayaran','tgl_jatuh_tempo','status_pembayaran','total','diskon','grand_total','terbayar','sisa_tunggakan')
        ->first();

        //Data Detail Pembelian
        $detail = DB::table('detail_pembelian')
        ->join('produk_konversi_stok','detail_pembelian.produk_konversi_stok_id','=','produk_konversi_stok.id')
        ->join('produk','produk_konversi_stok.produk_id','=','produk.id')
        ->where('pembelian_id','=',$id)
        ->select('detail_pembelian.id','produk_konversi_stok.produk_id','produk.nama_produk','produk_konversi_stok.satuan','harga','qty','subtotal')
        ->get();
        
        $data = [
            'data_pembelian' => $data_pembelian,
            'detail' => $detail,
        ];
        return view('modules/report/laporan_pembelian/v_detail',$data);
    }

    //Data Ajax Pembayaran Pembelian Untuk Halaman Detail Laporan Pembelian
    function pembayaranPembelian($id){
        $pembayaran = DB::table('pembayaran_pembelian')
        ->where('pembelian_id','=',$id)
        ->select('id','jumlah','created_at')
        ->get();

        return datatables()->of($pembayaran)->toJson();
    }
}
