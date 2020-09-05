<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use App\KoreksiStok;

class LaporanKoreksiStokController extends Controller
{
    function index(){
        return view('modules/report/laporan_koreksi_stok/v_report');
    }

    function json(Request $request){
        //Initalization 
        $data = DB::table('koreksi_stok')
                ->select('koreksi_stok.id','users.name','koreksi_stok.keterangan','koreksi_stok.created_at')        
                ->leftJoin('users','koreksi_stok.user_id','=','users.id')
                ->get();
        
        return datatables()->of($data)->toJson();
    }

    function detail($id){
        $data_master_koreksi_stok = DB::table('koreksi_stok')
            ->select('koreksi_stok.id','users.name','koreksi_stok.keterangan','koreksi_stok.created_at')        
            ->leftJoin('users','koreksi_stok.user_id','=','users.id')
            ->where('koreksi_stok.id',$id)
            ->first();

        $data_detail_koreksi_stok = DB::table('detail_koreksi_stok')
            ->join('produk_konversi_stok','detail_koreksi_stok.produk_konversi_stok_id','=','produk_konversi_stok.id')
            ->join('produk','produk_konversi_stok.produk_id','=','produk.id')
            ->where('koreksi_stok_id','=',$id)
            ->select('produk_konversi_stok.produk_id','produk.nama_produk','produk_konversi_stok.satuan','qty_awal','qty_akhir')
            ->get();


        $data = [
            'data_master_koreksi_stok' => $data_master_koreksi_stok,
            'data_detail_koreksi_stok' => $data_detail_koreksi_stok,
        ];

        return view('modules/report/laporan_koreksi_stok/v_detail',$data);
    }
}
