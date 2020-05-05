<?php

namespace App\Http\Controllers;

use App\KategoriProduk;
use Illuminate\Http\Request;
use Response;

class KategoriProdukController extends Controller
{
    public function json(){
        return datatables()->of(KategoriProduk::query())->toJson();
    }
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        return view('modules/kategori_produk/v_index');
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
            'nama_kategori' => $request->nama,
        ];

        if($data = KategoriProduk::updateOrCreate(['id' => $id ], $array_data)){
            return "1";
        }else{
            return "0";
        }
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\KategoriProduk  $kategoriProduk
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $where = array('id' => $id);
        $data  = KategoriProduk::where($where)->first();
 
        return Response::json($data);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\KategoriProduk  $kategoriProduk
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $data = KategoriProduk::where('id',$id)->delete();
        return Response::json($data);
    }
}
