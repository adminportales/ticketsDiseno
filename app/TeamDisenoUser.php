<?php

namespace App;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class TeamDisenoUser extends Model
{
    use HasFactory;
    public $table = 'team_diseno_user';
    protected $fillable = ['team_diseno_id', 'user_id'];

    public function teamDiseno()
    {
        return $this->belongsTo(TeamDiseno::class, 'team_diseno_id');
    }

    public function user()
    {
        return $this->belongsTo(User::class, 'user_id');
    }
}
