<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Classes extends Model
{
    use HasFactory;
    protected $fillable =[
        'code',
        'class',
        'rank'
    ];

    public function employee(){
        return $this->hasOne('App\Models\Employee');
    }
    
    public function class_history($nip){
        return $this->hasMany('App\Models\ClassHistory')->where('nip',$nip);
    }
    


}
