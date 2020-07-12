<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class PembayaranPenjualan extends Model
{
    protected $table = 'pembayaran_penjualan';
    protected $fillable = ['penjualan_id','jumlah','user_id'];
}
