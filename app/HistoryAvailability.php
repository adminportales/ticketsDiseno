<?php

namespace App;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class HistoryAvailability extends Model
{
    use HasFactory;

    // Crear el campo info y usuario
    protected $fillable = ['info', 'user_id'];

    public function user()
    {
        return $this->belongsTo('App\User');
    }
}
