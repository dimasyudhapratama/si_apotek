<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class DetailReturnPenjualan extends Model
{
    protected $table = 'detail_return_penjualan';
    protected $fillable = ['return_penjualan_id','produk_konversi_stok_id','produk_stok_detail_exp_date','harga','qty','subtotal'];
    public $timestamps = false;
}
