<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Office extends Model
{
    use HasFactory;
    protected $fillable =[
        'office_name',
        'office_address',
        'user_id'
    ];

    public function user()
    {
        return $this->hasOne('App\Models\User');
    }
    
    public function position()
    {
        return $this->hasOne('App\Models\Position');
    }

    public function program(){
        return $this->hasOne('App\Models\Program');
    }

    public function activity(){
        return $this->hasMany('App\Models\Activity');
    }
}
