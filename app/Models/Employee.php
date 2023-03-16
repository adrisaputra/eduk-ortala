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
        'position_id',
        'education_id',
        'unit_id',
    ];

    public function class(){
        return $this->belongsTo('App\Models\Class');
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
