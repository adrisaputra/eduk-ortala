<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Promotion extends Model
{
    use HasFactory;
    protected $fillable =[
        'employee_id',
        'nip',
        'year',
        'period',
        'last_promotion',
        'new_promotion',
        'promotion_type',
        'status',
        'note',
    ];

    public function employee(){
        return $this->belongsTo('App\Models\Employee');
    }
}
