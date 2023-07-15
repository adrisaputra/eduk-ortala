<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Unit extends Model
{
    use HasFactory;
    protected $fillable =[
        'code',
        'name',
        'parent_id',
        'parent_code',
        'leader_code',
        'leader_eselon',
        'leader_nip',
        'leader_name',
        'leader_call',
        'type_unit',
    ];

    public function employee(){
        return $this->hasOne('App\Models\Employee');
    }
}
