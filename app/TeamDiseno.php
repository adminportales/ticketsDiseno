<?php

namespace App;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class TeamDiseno extends Model
{
    use HasFactory;
    public $table = 'team_disenos';
    protected $fillable = ['name', 'role', 'user_id'];

    public function membersDiseno()
    {
        return $this->belongsToMany(User::class);
    }

    public function userDiseno()
    {
        return $this->belongsTo(User::class, 'user_id');
    }
}
