<?php

use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/

Route::get('/', function () {
    return view('welcome');
});

//Master Data
//Kategori Produk
Route::get('/kategori_produk/data','KategoriProdukController@json');
Route::Resource('kategori_produk','KategoriProdukController');
//Produk
// Route::get('/produk/data','ProdukController@json');
// Route::Resource('produk','ProdukController');
//Produsen
Route::get('/produsen/data','ProdusenController@json');
Route::Resource('produsen','ProdusenController');
//Supplier
Route::get('/supplier/data','SupplierController@json');
Route::Resource('supplier','SupplierController');
//Dokter
Route::get('/dokter/data','DokterController@json');
Route::Resource('dokter','DokterController');
//Customer
Route::get('/customer/data','CustomerController@json');
Route::Resource('customer','CustomerController');
//User
// Route::get('/user/data','UserController@json');
// Route::Resource('user','UserController');

//Informasi
//Kontak Developer
Route::get('/kontak_developer', function () {
    return view('modules/informasi/v_kontak_developer');
});
Route::get('/tentang_sistem', function () {
    return view('modules/informasi/v_tentang_sistem');
});

//Test Template
// Route::get('/', function () {
//     return view('master_template');
// });
