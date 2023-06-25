<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ClassHistory extends Model
{
    use HasFactory;
    protected $fillable =[
        'employee_id',
        'nip',
        'classes_id',
        'rank',
        'class',
        'tmt',
        'sk_official',
        'sk_number',
        'mk_year',
        'mk_month',
        'current_rank',
        'no_bkn',
        'date_bkn',
        'kp_type'
    ];
}
