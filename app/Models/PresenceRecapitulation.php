<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class PresenceRecapitulation extends Model
{
    use HasFactory;
    protected $fillable =[
        'parent_unit_id',
        'day',
        'date',
        'employee_amount',
        'tl',
        'ct',
        's',
        'h',
        'th',
        'file',
        'desc'
    ];
}
