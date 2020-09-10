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
        $data = DB::table('pembelian')
            ->leftJoin('users','pembelian.user_id','=','users.id')
            ->leftJoin('supplier','pembelian.supplier_id','=', 'supplier.id')
            ->select('pembelian.id','pembelian.created_at','users.name','supplier.nama','cara_pembayaran','tgl_jatuh_tempo','status_pembayaran','grand_total');

        if($request->tipe_pencarian <> "0"){ //Menampilkan Data Dengan Tipe Pencarian
            if($request->tipe_pencarian == "1"){
                $date = $request->tahun.'-'.$request->bulan.'-'.$request->tanggal;
                $data->whereDate('pembelian.created_at',$date);

            }else if($request->tipe_pencarian == "2"){
                $data->whereMonth('pembelian.created_at',$request->bulan)
                    ->whereYear('pembelian.created_at',$request->tahun);
            }else if($request->tipe_pencarian == "3"){
                $data->whereYear('pembelian.created_at',$request->tahun);

            }else if($request->tipe_pencarian == "4"){
                $data->whereBetween('pembelian.created_at', [$request->tanggal_awal, $request->tanggal_akhir]);

            }
        }
        
        return datatables()->of($data->get())->toJson();
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
