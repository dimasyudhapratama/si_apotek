<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class LoginxController extends Controller
{
    function index(){
        return view('login_view');
    }

    function loginCheck(Request $request){
        // $auth = Auth::attempt([
        //     'username' => $request->username,
        //     'password' => $request->password
        // ]);
        $auth = Auth::attempt([
            'username' => "d",
            'password' => "d"
        ]);

        if($auth){
            return "1";
        }else{
            return "0";
        }
    }
    
    function logout(){
        echo "b";
    }
}
