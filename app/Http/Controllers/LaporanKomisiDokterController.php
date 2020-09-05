<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class LaporanKomisiDokterController extends Controller
{
    function index(){
        return view('modules/report/laporan_komisi_dokter/v_report');
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

    function detailKomisiBulanandokter($dokter_id,$year,$month){
        $dokter = DB::table('dokter')
            ->select('dokter.nama')
            ->find($dokter_id);

        $penjualan = DB::table('penjualan')
            ->select('penjualan.id','penjualan.grand_total','penjualan.created_at')
            ->whereMonth('penjualan.created_at',$month)
            ->whereYear('penjualan.created_at',$year)
            ->where('dokter_id',$dokter_id)
            ->get();

        $data = [
            'year' => $year,
            'month' => $month,
            'dokter' => $dokter,
            'penjualan' => $penjualan
        ];
            
        return view('modules/report/laporan_komisi_dokter/detail_komisi_bulanan_dokter',$data);
    }
}
