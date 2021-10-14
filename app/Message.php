<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Message extends Model
{
    protected $fillable = [
        'seller_id',
        'seller_name',
        'designer_id',
        'designer_name',
        'message',
        'ticket_id',
    ];
}
