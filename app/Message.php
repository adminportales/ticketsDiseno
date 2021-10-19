<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Message extends Model
{
    protected $fillable = [
        'transmitter_id',
        'transmitter_name',
        'transmitter_role',
        'receiver_id',
        'receiver_name',
        'message',
        'ticket_id',
    ];
}
