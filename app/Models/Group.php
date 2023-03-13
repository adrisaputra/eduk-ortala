<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Group extends Model
{
    use HasFactory;
	protected $fillable =[
        'group_name',
        'user_id'
    ];

    public function user()
    {
        return $this->hasOne('App\Models\User');
    }
    
    public function menu_access()
    {
        return $this->hasOne('App\Models\MenuAccess');
    }
}
