<?php

namespace App;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Subtype extends Model
{
    use HasFactory;
    protected $fillable = [
        'id_type',
        'subtype'
    ];
    public function tickets()
    {
        return $this->hasMany('App\Ticket');
    }
    public function typeTicket()
    {
        return $this->hasMany('App\type', 'id_type');
    }
}
