<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Produsen extends Model
{
    protected $table = 'produsen';
    protected $fillable = ['nama','no_hp','email','bank','no_rekening'];
}
