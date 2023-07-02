<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class LeaveHistory extends Model
{
    use HasFactory;
    protected $fillable =[
        'employee_id',
        'nip',
        'type',
        'hp',
        'info',
        'status',
        'final',
        'duration',
        'note',
        'file',
        'date_start',
        'date_finish',
        'letter_no',
        'letter_date'
    ];
}
