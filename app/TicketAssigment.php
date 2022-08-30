<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class TicketAssigment extends Model
{
    protected $fillable = [
        'designer_id',
        'type_id'
    ];
    public function user()
    {
        return $this->belongsTo(User::class, 'designer_id');
    }
}
