<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Student extends Model
{
    use HasFactory;
    protected $table ='students';
    protected $primaryKey = 'stud_id';

    protected $hidden = [
        // 'stud_id',
    ];

    public function getFullnameAttribute(){
        return ucwords(strtolower($this->fname).' '.strtolower($this->lname));
    }

    public function stud_grade(){
        return $this->belongsTo(StudentGrade::class,'stud_id','stud_id')
        ->withDefault([
            'prelim'=> 0,
            'midterm'=> 0,
            'finals'=> 0,
            'remarks'=>NULL,
            'equivalent'=>NULL,
            'final_grade'=>NULL,
            'completion'=>NULL,
        ])
        ->select([
            'grade_id',
            'prelim',
            'midterm',
            'finals',
            'remarks',
            'equivalent',
            'final_grade',
            'completion',
        ]);
    }
}
