<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class FilesDelivery extends Model
{
    protected $fillable = [
        'ticket_delivery_id',
        'file_location'
    ];
}
