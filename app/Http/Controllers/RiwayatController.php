<?php

namespace App\Http\Controllers;

use App\Riwayat;
use Illuminate\Http\Request;

class RiwayatController extends Controller
{
    function index(){
        return view('modules/riwayat/v_index');
    }

    function json(){
        return datatables()->of(Riwayat::query())->toJson();
    }
}
