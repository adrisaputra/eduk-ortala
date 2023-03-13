<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Menu extends Model
{
    use HasFactory;
	protected $fillable =[
        'menu_name',
        'attribute',
        'link',
        'position',
        'desc',
        'category',
        'status',
        'user_id'
    ];
}
