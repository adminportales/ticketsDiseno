<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Technique extends Model
{
    protected $fillable = [
        'name'
    ];
    public $timestamps = false;
}
