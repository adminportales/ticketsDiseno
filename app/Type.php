<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Type extends Model
{
    protected $fillable = [
        'type'
    ];
    public $timestamps = false;

    public function tickets()
    {
        return $this->hasMany('App\Ticket');
    }
    public function subType()
    {
        return $this->belongsTo('App\Subtype');
    }
}
