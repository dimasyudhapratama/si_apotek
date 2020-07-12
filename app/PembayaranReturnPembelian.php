<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class PembayaranReturnPembelian extends Model
{
    protected $table = 'pembayaran_return_pembelian';
    protected $fillable = ['return_pembelian_id','jumlah','user_id'];
}
