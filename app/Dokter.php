<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Dokter extends Model
{
    protected $table = 'dokter';
    protected $fillable = ['nama','no_hp','email','bank','no_rekening'];
    public $timestamps = false;
}
