<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class ProdukStokDetail extends Model
{
    protected $table = 'produk_stok_detail';
    protected $fillable = ['produk_konversi_stok_id','exp_date','jumlah'];
    public $timestamps = false;
}
