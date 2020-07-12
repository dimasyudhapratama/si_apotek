<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class DashboardController extends Controller
{
    function index(){
        return view('modules/dashboard/v_dashboard');
    }

    //Fungsi Untuk Mendapatkan Scorecard Harian
    function dailyScoreCard(){
        //Mencari Tanggal Hari Ini
        $date = date('Y-m-d');

        //Data Penjualan Harian
        $data_penjualan_harian = DB::table('pembayaran_penjualan')
        ->select(DB::raw('COALESCE(SUM(jumlah),0) as total'))
        ->whereDate('created_at', $date)
        ->first();
        $penjualan_harian = $data_penjualan_harian->total;

        
        //Data Pembelian Harian
        $data_pembelian_harian = DB::table('pembayaran_pembelian')
        ->select(DB::raw('COALESCE(SUM(jumlah),0) as total'))
        ->whereDate('created_at', $date)
        ->first();
        $pembelian_harian = $data_pembelian_harian->total;


        //Data Return Penjualan Harian
        $data_return_penjualan_harian = DB::table('pembayaran_return_penjualan')
        ->select(DB::raw('COALESCE(SUM(jumlah),0) as total'))
        ->whereDate('created_at', $date)
        ->first();
        $return_penjualan_harian = $data_return_penjualan_harian->total;

        //Data Return Pembelian Harian
        $data_return_pembelian_harian = DB::table('pembayaran_return_pembelian')
        ->select(DB::raw('COALESCE(SUM(jumlah),0) as total'))
        ->whereDate('created_at', $date)
        ->first();
        $return_pembelian_harian = $data_return_pembelian_harian->total;


        //Data Dikumpulkan Menjadi 1 Array
        $data = array(
            'penjualan' => $penjualan_harian,
            'pembelian' => $pembelian_harian,
            'return_penjualan' => $return_penjualan_harian,
            'return_pembelian' => $return_pembelian_harian,

        );

        return $data;
    }

    //Fungsi Untuk Mengolah Data Chart Per Bulan dalam Satu Tahun
    function monthlyChart(){
        //Inisialisasi Variable
        $all_data = array();
        $data_penjualan = array();
        $data_pembelian = array();
        $data_return_penjualan = array();
        $data_return_pembelian = array();

        //Looping
        for($month=1;$month<=12;$month++){
            //Tahun
            $year = date('Y');

            //Data Penjualan Bulanan
            $data_penjualan_bulanan = DB::table('pembayaran_penjualan')
            ->select(DB::raw('COALESCE(SUM(jumlah),0) as total'))
            ->whereMonth('created_at', $month)
            ->whereYear('created_at', $year)
            ->first();
            $penjualan_bulanan = $data_penjualan_bulanan->total;
            
            //Data Pembelian Bulanan
            $data_pembelian_bulanan = DB::table('pembayaran_pembelian')
            ->select(DB::raw('COALESCE(SUM(jumlah),0) as total'))
            ->whereMonth('created_at', $month)
            ->whereYear('created_at', $year)
            ->first();
            $pembelian_bulanan = $data_pembelian_bulanan->total;

            //Data Return Penjualan Bulanan
            $data_return_penjualan_bulanan = DB::table('pembayaran_return_penjualan')
            ->select(DB::raw('COALESCE(SUM(jumlah),0) as total'))
            ->whereMonth('created_at', $month)
            ->whereYear('created_at', $year)
            ->first();
            $return_penjualan_bulanan = $data_return_penjualan_bulanan->total;

            //Data Return Pembelian Bulanan
            $data_return_pembelian_bulanan = DB::table('pembayaran_return_pembelian')
            ->select(DB::raw('COALESCE(SUM(jumlah),0) as total'))
            ->whereMonth('created_at', $month)
            ->whereYear('created_at', $year)
            ->first();
            $return_pembelian_bulanan = $data_return_pembelian_bulanan->total;


            //Data Dikumpulkan Menjadi 1 Array
            $data_per_month = array(
                'data_penjualan' => $penjualan_bulanan,
                'data_pembelian' => $pembelian_bulanan,
                'data_return_penjualan' => $return_penjualan_bulanan,
                'data_return_pembelian' => $return_pembelian_bulanan,

            );

            $all_data[] = $data_per_month;
        }
        
        //Data Yang Akan Dikirim Ke Front End
        return $all_data;

    }

    //Fungsi Untuk Mengolah Data Chart Per Hari dalam satu bulan
    function dailyChart(){
        //Inisialisasi Variable
        $data_penjualan = array();
        $data_pembelian = array();
        $data_return_penjualan = array();
        $data_return_pembelian = array();

        //Mencari Data Bulan Sekarang
        $last_date_in_month = date('t');

        //Looping
        for($date_increment=1;$date_increment<=$last_date_in_month;$date_increment++){
            //Tanggal
            $date = date('Y-m-').$date_increment;

            //Data Penjualan Harian
            $data_penjualan_harian = DB::table('pembayaran_penjualan')
            ->select(DB::raw('COALESCE(SUM(jumlah),0) as total'))
            ->whereDate('created_at', $date)
            ->first();
            $penjualan_harian = $data_penjualan_harian->total;

            
            //Data Pembelian Harian
            $data_pembelian_harian = DB::table('pembayaran_pembelian')
            ->select(DB::raw('COALESCE(SUM(jumlah),0) as total'))
            ->whereDate('created_at', $date)
            ->first();
            $pembelian_harian = $data_pembelian_harian->total;


            //Data Return Penjualan Harian
            $data_return_penjualan_harian = DB::table('pembayaran_return_penjualan')
            ->select(DB::raw('COALESCE(SUM(jumlah),0) as total'))
            ->whereDate('created_at', $date)
            ->first();
            $return_penjualan_harian = $data_return_penjualan_harian->total;

            //Data Return Pembelian Harian
            $data_return_pembelian_harian = DB::table('pembayaran_return_pembelian')
            ->select(DB::raw('COALESCE(SUM(jumlah),0) as total'))
            ->whereDate('created_at', $date)
            ->first();
            $return_pembelian_harian = $data_return_pembelian_harian->total;


            //Data Dikumpulkan Menjadi 1 Array
            $data_per_day = array(
                'data_penjualan' => $penjualan_harian,
                'data_pembelian' => $pembelian_harian,
                'data_return_penjualan' => $return_penjualan_harian,
                'data_return_pembelian' => $return_pembelian_harian,

            );

            $all_data[] = $data_per_day;
        }
        
        //Data Yang Akan Dikirim Ke Front End
        return $all_data;

    }
}
