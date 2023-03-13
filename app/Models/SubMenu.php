<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class SubMenu extends Model
{
    use HasFactory;
	protected $fillable =[
        'menu_id',
        'sub_menu_name',
        'link',
        'attribute',
        'position',
        'desc',
        'status',
        'user_id'
    ];
}
