<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class TrainingHistory extends Model
{
    use HasFactory;
    protected $fillable =[
        'employee_id',
        'nip',
        'name',
        'place',
        'organizer',
        'generation',
        'start',
        'finish',
        'hours',
        'diploma_number',
        'diploma_date',
        'status'
    ];
}
