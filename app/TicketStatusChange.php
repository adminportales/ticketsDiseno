<?php

namespace App;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class TicketStatusChange extends Model
{
    use HasFactory;

    protected $fillable = ['ticket_id', 'status_id', 'status'];
}
