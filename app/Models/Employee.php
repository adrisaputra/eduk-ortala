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
        'parent_unit_id',
    ];

    ## Scopes
    public function scopeGrouping($query){
        return $query->groupBy('employees.nip');
    }

    public function scopeSorting($query){
        return $query->orderByRaw("FIELD(status, 'PNS', 'CPNS') DESC")
                    ->orderBy('status', 'ASC')
                    ->orderBy('class_id','DESC')
                    ->orderBy('class_histories.tmt','DESC')
                    ->orderBy('unit_id','ASC')
                    ->orderBy('class_histories.mk_month','DESC')
                    ->orderBy('date_of_birth','ASC');
    }

    public function scopePagination($query){
        return $query->paginate(25)->onEachSide(1);
    }

    public function scopeStatus($query){
        return $query->whereIn("status",['PNS', 'CPNS']);
    }

    public function scopeKeyword($query, $employee, $parent_unit_id){
        return $query->where(function ($query) use ($employee) {
                $query->where('employees.nip', 'LIKE', '%'.$employee.'%')
                ->orWhere('employees.name', 'LIKE', '%'.$employee.'%')
                ->orWhere('employees.status', 'LIKE', '%'.$employee.'%');
            })
            ->when(!empty($parent_unit_id), function ($query) use ($parent_unit_id) {
                $query->whereHas('parent_unit', function ($query) use ($parent_unit_id) {
                    $query->where('parent_unit_id', $parent_unit_id);
                });
            });
    }

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

    public function parent_unit(){
        return $this->belongsTo('App\Models\ParentUnit');
    }

    public function parent(){
        return $this->belongsTo('App\Models\Unit', 'parent_id');
    }
}
