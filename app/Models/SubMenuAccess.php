<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class SubMenuAccess extends Model
{
     use HasFactory;
	protected $fillable =[
        'menu_access_id',
        'group_id',
        'menu_id',
        'sub_menu_id',
        'create',
        'read',
        'update',
        'delete',
        'print',
        'status',
        'user_id'
    ];

    public function group(){
        return $this->belongsTo(Group::class, 'group_id');
    }

    public function menu(){
        return $this->belongsTo(Menu::class, 'menu_id');
    }
}
