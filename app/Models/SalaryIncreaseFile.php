<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class SalaryIncreaseFile extends Model
{
    use HasFactory;
    protected $fillable =[
        'salary_increase_id',
        'name',
        'file'
    ];

    ## Scopes
    public function scopeSorting($query){
        return $query->latest();
    }

    public function scopePagination($query){
        return $query->paginate(25)->onEachSide(1);
    }

    public function scopeSalaryIncrease($query, $salary_increase){
        return $query->where('salary_increase_id',$salary_increase);
    }

    public function scopeKeyword($query, $macro){
        return $query->where(function ($query) use ($macro) {
                            $query->where('year', 'LIKE', '%' . $macro . '%');
                        });
    }
}
