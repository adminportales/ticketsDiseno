<?php

namespace App;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class SatisfactionModel extends Model
{
    use HasFactory;
    protected $fillable = ['designer', 'seller', 'ticket_id', 'question', 'answer', 'comment'];
}
