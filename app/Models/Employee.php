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
        'mk_month',
        'mk_year',
        'class_id',
        'education_id',
        'position',
        'unit_id',
    ];

    public function classes(){
        return $this->belongsTo(Classes::class, 'class_id');
    }

    public function class_history_first($nip){
        return $this->belongsTo(ClassHistory::class, 'nip', 'nip')->where('nip',$nip)->orderBy('classes_id','ASC');
    }

    public function position_history($nip){
        return $this->belongsTo(PositionHistory::class, 'nip', 'nip')->where('current_position','Ya')->where('nip',$nip);
    }

    public function training_history_first($nip){
        return $this->belongsTo(TrainingHistory::class, 'nip', 'nip')->where('nip',$nip)->where('name', 'like', '%PIM%')->orderBy('start','DESC');
    }

    public function education_history_last($nip){
        return $this->belongsTo(EducationHistory::class, 'nip', 'nip')->where('current_education','Ya')->where('nip',$nip);
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
