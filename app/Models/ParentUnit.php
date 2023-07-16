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

    ## Scopes
    public function scopeSorting($query){
        return $query->latest();
    }

    public function scopePagination($query){
        return $query->paginate(25)->onEachSide(1);
    }

    public function scopePromotion($query, $promotion){
        return $query->where('promotion_id',$promotion);
    }

    public function scopeKeyword($query, $macro){
        return $query->where(function ($query) use ($macro) {
                            $query->where('year', 'LIKE', '%' . $macro . '%');
                        });
    }

}
