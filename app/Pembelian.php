<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Alfa6661\AutoNumber\AutoNumberTrait;

class Pembelian extends Model
{
    use AutoNumberTrait;

    protected $table = 'pembelian';
    protected $fillable = [
        'user_id',
        'supplier_id',
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
                    return 'K' . date('Ymd') .  '?'; 
                },
                'length' => 4,
            ]
        ];
    }
    
    

    
}
