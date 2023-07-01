<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class AbsenceHistory extends Model
{
    use HasFactory;
    protected $fillable =[
        'employee_id',
        'nip',
        'date',
        'in_type',
        'in',
        'out',
        'time_zone'
    ];
}
