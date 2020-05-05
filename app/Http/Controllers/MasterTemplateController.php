<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class MasterTemplateController extends Controller
{
    function index(){
        return view('master_template');
    }
}
