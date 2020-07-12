<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Alfa6661\AutoNumber\AutoNumberTrait;

class ReturnPenjualan extends Model
{
    use AutoNumberTrait;

    protected $table = 'return_penjualan';
    protected $fillable = [
        'penjualan_id',
        'user_id',
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
                    return 'RP' . date('Ymd') .  '?'; 
                },
                'length' => 4,
            ]
        ];
    }
}
