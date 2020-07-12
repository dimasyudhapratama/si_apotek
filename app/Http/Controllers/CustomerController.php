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
    
    
    public function index()
    {
        $customer =  Customer::all();
        return view('modules/customer/v_index',['customer'=> $customer]);
    }

    function plainData(){
        return $customer = Customer::get();
    }
    
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

    function saveCustomerReturnID(Request $request){
        $array_data = [
            'nama' => $request->nama_customer, 
            'no_hp' => $request->no_hp_customer
        ];

        if($data = Customer::create($array_data)){
            return $data->id;
        }else{
            return "0";
        }
    }
    
    public function edit($id)
    {
        $where = array('id' => $id);
        $data  = Customer::where($where)->first();
 
        return Response::json($data);
    }
    
    public function destroy($id)
    {
        $data = Customer::where('id',$id)->delete();
        return Response::json($data);
    }
}
