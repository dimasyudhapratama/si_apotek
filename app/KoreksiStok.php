<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Alfa6661\AutoNumber\AutoNumberTrait;

class KoreksiStok extends Model
{
    use AutoNumberTrait;

    protected $table = 'koreksi_stok';
    protected $fillable = ['user_id','keterangan'];

    public $incrementing = false;

    public function getAutoNumberOptions()
    {
        return [
            'id' => [
                'format' => function () {
                    return 'KS' . date('Ymd') .  '?'; 
                },
                'length' => 4,
            ]
        ];
    }
}
