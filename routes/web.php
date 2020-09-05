<?php

use Illuminate\Support\Facades\Route;

Auth::routes();

Route::group(['middleware' => 'auth'], function () {

    //Riwayat
    Route::get('/riwayat','RiwayatController@index');
    Route::get('/riwayat/data','RiwayatController@json');

    //Komisi Dokter
    Route::get('/komisi_dokter','KomisiDokterController@index');

    //Transaksi
    //Pembelian
    Route::get('/pembelian','PembelianController@index');
    Route::get('/pembelian/getDetailProduk/{id}','PembelianController@produk');
    Route::get('/pembelian/getSatuanProduk/{id}','PembelianController@satuanProduk');
    Route::get('/pembelian/getKonversiSatuanProduk/{id}','PembelianController@konversiSatuanProduk');
    Route::post('/pembelian/store','PembelianController@store');
    Route::post('/pembelian/simpanPembayaran','PembelianController@simpanPembayaranPembelian');
    Route::get('/pembelian/struka4/{id}','PembelianController@strukA4');



    //Penjualan
    Route::get('/penjualan','PenjualanController@index');
    Route::get('/penjualan/getDetailProduk/{id}','PenjualanController@produk');
    Route::get('/penjualan/getNonExpiredDataProduk/{id}','PenjualanController@produkNonExpired');
    Route::post('/penjualan/getSatuanProduk/','PenjualanController@satuanProduk');
    Route::post('/penjualan/hargaProduk','PenjualanController@hargaProduk');
    Route::post('/penjualan/store','PenjualanController@store');
    Route::post('/penjualan/simpanPembayaran','PenjualanController@simpanPembayaranPenjualan');
    Route::get('/penjualan/struk58/{id}','PenjualanController@struk58');

    // Return Pembelian
    Route::get('/return_pembelian','ReturnPembelianController@index');
    Route::get('/return_pembelian/getDataPembelianByPembelianId/{id}','ReturnPembelianController@getDataPembelianByPembelianId');
    Route::post('/return_pembelian/store','ReturnPembelianController@store');
    Route::post('/return_pembelian/simpanPembayaran','ReturnPembelianController@simpanPembayaranReturnPembelian');


    // Return Penjualan
    Route::get('/return_penjualan','ReturnPenjualanController@index');
    Route::get('/return_penjualan/getDataPenjualanByPenjualanId/{id}','ReturnPenjualanController@getDataPenjualanByPenjualanId');
    Route::post('/return_penjualan/store','ReturnPenjualanController@store');
    Route::post('/return_penjualan/simpanPembayaran','ReturnPenjualanController@simpanPembayaranReturnPenjualan');

    //Koreksi Stok
    Route::get('/koreksi_stok','KoreksiStokController@index');
    Route::get('/koreksi_stok/getDetailProduk/{id}','KoreksiStokController@produk');
    Route::get('/koreksi_stok/getNonExpiredDataProduk/{id}','KoreksiStokController@produkNonExpired');
    Route::post('/koreksi_stok/getSatuanProduk/','KoreksiStokController@satuanProduk');
    Route::post('/koreksi_stok/store','KoreksiStokController@store');

    //Laporan
    //Cashflow
    //Laporan Pembelian
    Route::get('/laporan_pembelian','LaporanPembelianController@index');
    Route::post('/laporan_pembelian/data','LaporanPembelianController@json');
    Route::get('/cetak_a4_struk_pembelian/{id}','LaporanPenjualanController@CetakA4');
    Route::get('/cetak_58_struk_pembelian/{id}','LaporanPenjualanController@Cetak58');
    Route::get('/detail_pembelian/{id}','LaporanPembelianController@detail');
    Route::get('/detail_pembelian/pembayaran/{id}','LaporanPembelianController@pembayaranPembelian');

    //Laporan Penjualan
    Route::get('/laporan_penjualan','LaporanPenjualanController@index');
    Route::post('/laporan_penjualan/data','LaporanPenjualanController@json');
    Route::get('/laporan_penjualan/cetak_a4/{id}','LaporanPenjualanController@CetakA4');
    Route::get('/laporan_penjualan/cetak_58/{id}','LaporanPenjualanController@Cetak58');
    Route::get('/detail_penjualan/{id}','LaporanPenjualanController@detail');
    Route::get('/detail_penjualan/pembayaran/{id}','LaporanPenjualanController@PembayaranPenjualan');

    //Laporan Return Pembelian
    Route::get('/laporan_return_pembelian','LaporanReturnPembelianController@index');
    Route::post('/laporan_return_pembelian/data','LaporanReturnPembelianController@json');
    Route::get('/detail_return_pembelian/{id}','LaporanReturnPembelianController@detail');
    Route::get('/detail_return_pembelian/pembayaran/{id}','LaporanReturnPembelianController@pembayaran');


    //Laporan Return Penjualan
    Route::get('/laporan_return_penjualan','LaporanReturnPenjualanController@index');
    Route::post('/laporan_return_penjualan/data','LaporanReturnPenjualanController@json');
    Route::get('/detail_return_penjualan/{id}','LaporanReturnPenjualanController@detail');
    Route::get('/detail_return_penjualan/pembayaran/{id}','LaporanReturnPenjualanController@pembayaran');

    //Laporan Koreksi Stok
    Route::get('/laporan_koreksi_stok','LaporanKoreksiStokController@index');
    Route::post('/laporan_koreksi_stok/data','LaporanKoreksiStokController@json');
    Route::get('/detail_koreksi_stok/{id}','LaporanKoreksiStokController@detail');

    //Laporan Pajak
    Route::get('/laporan_pajak','LaporanPajakController@index');
    Route::get('/laporan_pajak/proccess','LaporanPajakController@proccess');

    //Laporan Komisi Dokter
    Route::get('/laporan_komisi_dokter','LaporanKomisiDokterController@index');
    Route::get('/laporan_komisi_dokter/proccess','LaporanKomisiDokterController@proccess');
    Route::get('/detail_komisi_bulanan_dokter/{dokter_id}/{tahun}/{bulan}','LaporanKomisiDokterController@detailKomisiBulanandokter');


    //Master Data
    //Kategori Produk
    Route::get('/kategori_produk/data','KategoriProdukController@json');
    Route::Resource('kategori_produk','KategoriProdukController');
    //Produk
    Route::get('/produk/data','ProdukController@json');
    Route::get('/produk/data_processed','ProdukController@jsonDataProcessed');
    Route::get('/produk','ProdukController@index');
    Route::post('/produk/store','ProdukController@store');
    Route::get('/produk/edit/{id}','ProdukController@edit');
    Route::post('/produk/update','ProdukController@update');
    Route::post('/produk/delete/{id}','ProdukController@delete');
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
    Route::get('/customer/plain_data','CustomerController@plainData');
    Route::post('/customer/storeNewCustomerReturnID','CustomerController@saveCustomerReturnID');
    Route::Resource('customer','CustomerController');
    //User
    Route::get('/user/data','UserController@json');
    Route::get('/user','UserController@index');
    Route::post('/user/store','UserController@store');
    Route::get('/user/edit/{id}','UserController@edit');
    Route::post('/user/update','UserController@update');
    Route::post('/user/update_password','UserController@updatePassword');

    //Informasi
    //Kontak Developer
    Route::get('/kontak_developer', function () {
        return view('modules/informasi/v_kontak_developer');
    });
    Route::get('/tentang_sistem', function () {
        return view('modules/informasi/v_tentang_sistem');
    });

    // Dashbard
    Route::get('/','DashboardController@index');
    Route::get('/dashboard','DashboardController@index');
    Route::get('/dashboard/daily_scorecard','DashboardController@dailyScoreCard');
    Route::get('/dashboard/monthly_chart','DashboardController@monthlyChart');
    Route::get('/dashboard/daily_chart','DashboardController@dailyChart');



    Route::get('/home', 'HomeController@index')->middleware('auth');

});