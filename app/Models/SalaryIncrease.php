<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class SalaryIncrease extends Model
{
    use HasFactory;
    protected $fillable =[
        'employee_id',
        'parent_unit_id',
        'nip',
        'old_salary',
        'placeman',
        'sk_date',
        'sk_number',
        'start_old_date',
        'year_old_salary',
        'month_old_salary',
        'new_salary',
        'year_new_salary',
        'month_new_salary',
        'class',
        'start_new_date',
        'status_employee',
        'next_kgb',
        'status',
        'note',
    ];

    public function employee(){
        return $this->belongsTo('App\Models\Employee');
    }

    public function parent_unit(){
        return $this->belongsTo('App\Models\ParentUnit');
    }
}
