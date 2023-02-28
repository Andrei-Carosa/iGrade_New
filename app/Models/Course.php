<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Course extends Model
{
    use HasFactory;
    protected $primaryKey = 'course_id';

    protected $hidden = [
        'course_id',
    ];

    public function course_program(){
        return $this->belongsTo(Program::class,'program_id','program_id');
    }
}
