<?php

namespace App\Http\Controllers;

use App\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Response;

class UserController extends Controller
{
    public function json(){
        return datatables()->of(User::query())->toJson();
    }

    public function index()
    {
        return view('modules/user/v_index');
    }

    public function store(Request $request)
    {   
        $array_data = [
            'name' => $request->nama, 
            'username' => $request->username,
            'roles' => $request->roles, 
            'status' => $request->status, 
            'password' => Hash::make($request->password_)
        ];

        if($data = User::create($array_data)){
            return "1";
        }else{
            return "0";
        }
    }

    public function edit($id)
    {
        $where = array('id' => $id);
        $data  = User::where($where)->first();
 
        return Response::json($data);
    }

    public function update(Request $request)
    {   
        $id = $request->id_;
        $array_data = [
            'name' => $request->nama, 
            'username' => $request->username,
            'roles' => $request->roles, 
            'status' => $request->status, 
            'password' => Hash::make($request->password_)
        ];

        if($data = User::where('id',$id)->update($array_data)){
            return "1";
        }else{
            return "0";
        }
    }

    public function updatePassword(Request $request)
    {   
        $id = $request->id_;
        $array_data = [
            'password' => Hash::make($request->password_)
        ];

        if($data = User::where('id',$id)->update($array_data)){
            return "1";
        }else{
            return "0";
        }
    }
}
