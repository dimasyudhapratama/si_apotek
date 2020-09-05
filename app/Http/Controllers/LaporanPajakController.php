<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class LaporanPajakController extends Controller
{
    function index(){
        return view('modules/report/laporan_pajak/v_report');
    }

    function proccess(Request $request){
        $month = $request->month ? $request->month : date('m', strtotime(date('Y-m')." -1 month"));
        $year = $request->year ? $request->year : date('Y', strtotime(date('Y-m')." -1 month"));
        $data = DB::table('dokter')
            ->leftJoin('penjualan','penjualan.dokter_id','=','dokter.id')
            ->select('dokter.id','dokter.nama',DB::raw('format(sum(penjualan.grand_total) * 2 / 100 ,2) as pendapatan_dokter'))
            ->whereMonth('penjualan.created_at',$month)
            ->whereYear('penjualan.created_at',$year)
            ->groupBy('dokter.id','dokter.nama')
            ->get();
        return json_encode($data);
    }
}
