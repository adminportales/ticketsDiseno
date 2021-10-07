<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class TicketInformation extends Model
{
    protected $fillable = [
        'ticket_id',
        'status_id',
        'customer',
        'technique',
        'description',
        'title',
        'logo',
        'product',
        'pantone',
    ];
}
