<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class PembayaranPembelian extends Model
{
    protected $table = 'pembayaran_pembelian';
    protected $fillable = ['pembelian_id','jumlah','user_id'];
}
