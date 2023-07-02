<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ParentHistory extends Model
{
    use HasFactory;
    protected $fillable =[
        'employee_id',
        'nip',
        'father_name',
        'father_birthplace',
        'father_birthdate',
        'father_work',
        'father_address',
        'father_rt',
        'father_rw',
        'father_phone',
        'father_codepos',
        'father_village',
        'father_district',
        'father_regency',
        'father_province',
        'mother_name',
        'mother_birthplace',
        'mother_birthdate',
        'mother_work',
        'mother_address',
        'mother_rt',
        'mother_rw',
        'mother_phone',
        'mother_codepos',
        'mother_village',
        'mother_district',
        'mother_regency',
        'mother_province',
    ];
}
