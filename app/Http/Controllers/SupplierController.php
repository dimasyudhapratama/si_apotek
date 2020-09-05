<?php

namespace App\Http\Controllers;

use App\Supplier;
use Illuminate\Http\Request;
use Response;

class SupplierController extends Controller
{
    public function json(){
        return datatables()->of(Supplier::query())->toJson();
    }
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        return view('modules/supplier/v_index');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $id = $request->id_;
        $array_data = [
            'nama' => $request->nama, 
            'no_hp' => $request->no_hp,
            'email' => $request->email, 
            'bank' => $request->bank,
            'no_rekening' => $request->no_rekening,
        ];

        if($data = Supplier::updateOrCreate(['id' => $id ], $array_data)){
            return "1";
        }else{
            return "0";
        }
    }
    public function edit($id)
    {
        $where = array('id' => $id);
        $data  = Supplier::where($where)->first();
 
        return Response::json($data);
    }
    
    public function destroy($id)
    {
        $data = Supplier::where('id',$id)->delete();
        return Response::json($data);
    }
}
