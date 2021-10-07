<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class FilesLocation extends Model
{
    protected $fillable = [
        'ticket_information_id',
        'file_location'
    ];
}
