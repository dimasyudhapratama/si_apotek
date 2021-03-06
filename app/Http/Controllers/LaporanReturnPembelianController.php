<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use App\ReturnPembelian;

class LaporanReturnPembelianController extends Controller
{
    //Halaman Index
    function index(){
        return view('modules/report/laporan_return_pembelian/v_report');
    }

    //Datatables Halaman Index
    public function json(Request $request){
        //Initalization 
        $data = DB::table('return_pembelian')
            ->join('pembelian','return_pembelian.pembelian_id','=','pembelian.id')
            ->leftJoin('users','return_pembelian.user_id','=','users.id')
            ->leftJoin('supplier','pembelian.supplier_id','=', 'supplier.id')
            ->select('return_pembelian.id','return_pembelian.pembelian_id','return_pembelian.created_at','users.name','supplier.nama','return_pembelian.status_pembayaran','return_pembelian.grand_total');
                
        if($request->tipe_pencarian <> "0"){ //Menampilkan Data Dengan Tipe Pencarian
            if($request->tipe_pencarian == "1"){
                $date = $request->tahun.'-'.$request->bulan.'-'.$request->tanggal;
                $data->whereDate('return_pembelian.created_at',$date);

            }else if($request->tipe_pencarian == "2"){
                $data->whereMonth('return_pembelian.created_at',$request->bulan)
                    ->whereYear('return_pembelian.created_at',$request->tahun);

            }else if($request->tipe_pencarian == "3"){
                $data->whereYear('return_pembelian.created_at',$request->tahun);

            }else if($request->tipe_pencarian == "4"){
                $data->whereBetween('return_pembelian.created_at', [$request->tanggal_awal, $request->tanggal_akhir]);

            }
        }
        
        return datatables()->of($data->get())->toJson();
    }

    //Halaman Detail Detail Laporan Pembelian
    function detail($id){
        //Data Pembelian
        $data_return_pembelian = DB::table('return_pembelian')
        ->join('pembelian','return_pembelian.pembelian_id','=','pembelian.id')
        ->leftJoin('users','return_pembelian.user_id','=','users.id')
        ->leftJoin('supplier','pembelian.supplier_id','=', 'supplier.id')
        ->where('return_pembelian.id','=',$id)
        ->select('return_pembelian.id','return_pembelian.pembelian_id','return_pembelian.created_at','users.name AS nama_user','supplier.nama AS nama_supplier','return_pembelian.status_pembayaran',
            'return_pembelian.total','return_pembelian.diskon','return_pembelian.grand_total','return_pembelian.terbayar','return_pembelian.sisa_tunggakan')
        ->first();

        //Data Detail Pembelian
        $detail = DB::table('detail_return_pembelian')
        ->join('produk_konversi_stok','detail_return_pembelian.produk_konversi_stok_id','=','produk_konversi_stok.id')
        ->join('produk','produk_konversi_stok.produk_id','=','produk.id')
        ->where('return_pembelian_id','=',$id)
        ->select('detail_return_pembelian.id','produk_konversi_stok.produk_id','produk.nama_produk','produk_konversi_stok.satuan','harga','qty','subtotal')
        ->get();
        
        $data = [
            'data_return_pembelian' => $data_return_pembelian,
            'detail' => $detail,
        ];
        return view('modules/report/laporan_return_pembelian/v_detail',$data);
    }

    //Data Ajax Pembayaran Pembelian Untuk Halaman Detail Laporan Return Pembelian
    function pembayaran($id){
        $pembayaran = DB::table('pembayaran_return_pembelian')
        ->where('return_pembelian_id','=',$id)
        ->select('id','jumlah','created_at')
        ->get();

        return datatables()->of($pembayaran)->toJson();
    }
}
