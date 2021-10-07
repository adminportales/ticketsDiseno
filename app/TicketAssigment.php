<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class TicketAssigment extends Model
{
    protected $fillable = [
        'designer_id',
        'type_id'
    ];
}
