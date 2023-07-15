<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ParentUnit extends Model
{
    use HasFactory;
    protected $fillable =[
        'code',
        'name',
        'leader_eselon',
        'leader_nip',
        'leader_name',
        'leader_call',
        'type_unit',
    ];
}
