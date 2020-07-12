<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class PembayaranReturnPenjualan extends Model
{
    protected $table = 'pembayaran_return_penjualan';
    protected $fillable = ['return_penjualan_id','jumlah','user_id'];
}
