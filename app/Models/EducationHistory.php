<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class EducationHistory extends Model
{
    use HasFactory;
    protected $fillable =[
        'employee_id',
        'nip',
        'education_id',
        'official_name',
        'diploma_number',
        'diploma_date',
        'school_name',
        'current_education',
    ];
}