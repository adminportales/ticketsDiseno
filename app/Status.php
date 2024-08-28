<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Status extends Model
{

    public $table = 'statuses';
    protected $fillable = [
        'status'
    ];
    public $timestamps = false;
}
