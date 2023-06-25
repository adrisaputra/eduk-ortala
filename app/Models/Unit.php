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
        'parent_code',
        'leader_code',
    ];

    public function employee(){
        return $this->hasOne('App\Models\Employee');
    }
}
