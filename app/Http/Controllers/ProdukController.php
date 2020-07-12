<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use App\Produk;
use App\ProdukKonversiStok;

class ProdukController extends Controller
{
    function __construct(){

    }

    function json(){
        $data = DB::table('produk')
        ->select('produk.id', 'kategori_produk.nama_kategori', 'produk.nama_produk', 'produsen.nama as nama_produsen', 'supplier.nama as nama_supplier', 'produk.stok_minimal', 'produk.status_pajak_produk')
        ->leftJoin('produsen','produk.produsen_id','=', 'produsen.id')
        ->leftJoin('supplier','produk.supplier_id','=', 'supplier.id')
        ->leftJoin('kategori_produk','produk.kategori_produk_id','=', 'kategori_produk.id')
        ->get();

        return datatables()->of($data)->toJson(); //Result To Datatable JSON
    }

    function jsonDataProcessed(){
        $data = DB::table('produk')
        ->select('produk.id','produk.nama_produk', 'produk.stok_minimal', 'produk.status_pajak_produk')
        ->get();

        return datatables()->of($data)->toJson(); //Result To Datatable JSON
    }

    function kategori_produk(){
        $data_from_db = DB::table('kategori_produk')
        ->select('id','nama_kategori')
        ->get();
        return $data_from_db;
    }

    function produsen(){
        $data_from_db = DB::table('produsen')
        ->select('id','nama')
        ->get();
        return $data_from_db;
    }

    function supplier(){
        $data_from_db = DB::table('supplier')
        ->select('id','nama')
        ->get();
        return $data_from_db;
    }

    function index(){
        $data = array(
            'kategori_produk' => $this->kategori_produk(),
            'produsen' => $this->produsen(),
            'supplier' => $this->supplier()
        );
        return view('modules/produk/v_index',$data);
    }

    function store(Request $request){
        //Save Ke Tabel Produk
        $produk_id = $request->id_;
        $array_data_produk = [
            'id' => $produk_id,
            'kategori_produk_id' => $request->kategori,
            'produsen_id' => $request->produsen,
            'supplier_id' => $request->supplier,
            'nama_produk' => $request->nama_produk, 
            'harga_beli' => $request->harga_beli,
            'stok_minimal' => $request->stok_minimal, 
            'level_satuan' => $request->level_satuan,
            'status_pajak_produk' => $request->margin_pajak,
        ];
        $save_produk = Produk::updateOrCreate(['id' => $produk_id ], $array_data_produk);
        
        //Save Ke Tabel Produk Konversi Stok
        // print_r($request->data_konversi);
        $data_konversi = $request->data_konversi;
        for($i=1;$i<=4;$i++){
            $produk_konversi_stok_id = $data_konversi[$i]['id'];
            $status_aktif = "1";
            if($i > $request->level_satuan){
                $status_aktif = "0";
            }
            // echo $status_aktif."<br>";
            $array_data_produk_konversi = [
                'produk_id' => $produk_id,
                'status_aktif' => $status_aktif,
                'level' => $i,
                'satuan' => $data_konversi[$i]['satuan_jual'],
                'nilai_konversi' => $data_konversi[$i]['nilai_konversi'],
                'laba_harga_biasa' => $data_konversi[$i]['margin_biasa'],
                'harga_biasa' => $data_konversi[$i]['harga_biasa'],
                'laba_harga_resep' => $data_konversi[$i]['margin_resep'],
                'harga_resep' => $data_konversi[$i]['harga_resep'],
            ];
            $save_produk_konversi_stok = ProdukKonversiStok::updateOrCreate(['id' => $produk_konversi_stok_id ], $array_data_produk_konversi);
        }
        return "1";
    }


}
