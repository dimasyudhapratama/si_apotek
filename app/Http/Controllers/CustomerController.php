<?php

namespace App\Http\Controllers;

use App\Customer;
use Illuminate\Http\Request;
use Response;

class CustomerController extends Controller
{
    public function json(){
        return datatables()->of(Customer::query())->toJson();
    }
    
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $customer =  Customer::all();
        return view('modules/customer/v_index',['customer'=> $customer]);
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
            'no_hp' => $request->no_hp
        ];

        if($data = Customer::updateOrCreate(['id' => $id ], $array_data)){
            return "1";
        }else{
            return "0";
        }
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Customer  $customer
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $where = array('id' => $id);
        $data  = Customer::where($where)->first();
 
        return Response::json($data);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Customer  $customer
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $data = Customer::where('id',$id)->delete();
        return Response::json($data);
    }
}
