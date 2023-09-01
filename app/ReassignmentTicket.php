<?php

namespace App;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ReassignmentTicket extends Model
{
    use HasFactory;

    protected $table = 'reassignment_tickets';

    // Columnas que se pueden llenar masivamente (si es necesario)
    protected $fillable = [
        'ticket_id',
        'designer_id',
        'designer_name',
        'designer_receives_id',
        'designer_receives',
        'reception_date',
        'status_type',
        'created_at',
        'updated_at'	

    ];
}
