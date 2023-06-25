<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Employee extends Model
{
    use HasFactory;
    protected $fillable =[
        'nip',
        'name',
        'front_title',
        'back_title',
        'birthplace',
        'date_of_birth',
        'gender',
        'status',
        'employee_type',
        'religion',
        'address',
        'no_karpeg',
        'no_askes',
        'no_taspen',
        'no_karis_karsu',
        'no_npwp',
        'class_id',
        'education_id',
        'position',
        'unit_id',
    ];

    public function classes(){
        return $this->belongsTo('App\Models\Classes');
    }

    public function position(){
        return $this->belongsTo('App\Models\Position');
    }
    
    public function education(){
        return $this->belongsTo('App\Models\Education');
    }
    
    public function unit(){
        return $this->belongsTo('App\Models\Unit');
    }
}
