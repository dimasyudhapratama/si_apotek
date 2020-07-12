<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Alfa6661\AutoNumber\AutoNumberTrait;

class Penjualan extends Model
{
    use AutoNumberTrait;

    protected $table = 'penjualan';
    protected $fillable = [
        'user_id',
        'dokter_id',
        'customer_id',
        'tipe_penjualan',
        'cara_pembayaran',
        'tgl_jatuh_tempo',
        'status_pembayaran',
        'total',
        'diskon',
        'grand_total',
        'terbayar',
        'sisa_tunggakan',
        'uang_pembayaran',
        'kembalian_pembayaran'
    ];
    public $incrementing = false;

    public function getAutoNumberOptions()
    {
        return [
            'id' => [
                'format' => function () {
                    return 'P' . date('Ymd') .  '?'; 
                },
                'length' => 4,
            ]
        ];
    }
}
