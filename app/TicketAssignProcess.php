<?php

namespace App;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class TicketAssignProcess extends Model
{
    use HasFactory;

    public $table = 'ticket_assign_processes';

    protected $fillable = [
        'ticket_id',
        'designer_id',
        'designer_name',
        'designer_received_id',
        'designer_received_name',
        'date_response',
        'status',
    ];
}
