<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class College extends Model
{
    use HasFactory;
    protected $primaryKey = 'college_id';

    protected $hidden = [
        'college_id',
    ];

    public function college_dean(){
        return $this->belongsTo(Employee::class,'dean_id','p_id');
    }
}
