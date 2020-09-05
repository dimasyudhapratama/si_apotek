<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Dokter;
use App\Penjualan;

class KomisiDokterController extends Controller
{
    function index(){
        $dokter = Dokter::get();
        return view('modules/komisi_dokter/v_index',['dokter' => $dokter]);
    }

    function hitungKomisiDokter(Request $request){

    }
}
