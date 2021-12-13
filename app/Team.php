<?php

namespace App;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Team extends Model
{
    use HasFactory;
    protected $fillable = [
        'name',
        'user_id',
        'role'
    ];
    public function members()
    {
        return $this->belongsToMany(User::class);
    }
    public function user()
    {
        return $this->belongsTo(User::class, 'user_id');
    }
}
