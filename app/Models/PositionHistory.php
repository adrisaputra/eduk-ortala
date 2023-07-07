<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class PositionHistory extends Model
{
    use HasFactory;
    protected $fillable =[
        'employee_id',
        'nip',
        'unit',
        'position_type',
        'position',
        'eselon',
        'tmt',
        'sk_number',
        'sk',
        'sk_date',
        'official_name',
        'sworn_status',
        'current_position',
    ];

    public function employee(){
        return $this->belongsTo(Employee::class, 'employee_id');
    }
    

}