<?php

namespace App\Http\Controllers;

use App\Produsen;
use Illuminate\Http\Request;
use Response;

class ProdusenController extends Controller
{
    public function json(){
        return datatables()->of(Produsen::query())->toJson();
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $produsen =  Produsen::all();
        return view('modules/produsen/v_index',['produsen'=> $produsen]);
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

        if($data = Produsen::updateOrCreate(['id' => $id ], $array_data)){
            return "1";
        }else{
            return "0";
        }
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Produsen  $produsen
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $where = array('id' => $id);
        $data  = Produsen::where($where)->first();
 
        return Response::json($data);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Produsen  $produsen
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $data = Produsen::where('id',$id)->delete();
        return Response::json($data);
    }
}
