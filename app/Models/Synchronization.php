<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Synchronization extends Model
{
    use HasFactory;
    protected $fillable =[
        'category',
        'count_all_data',
        'count_sync_data',
        'status'
    ];
}
