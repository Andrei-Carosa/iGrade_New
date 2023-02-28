<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class StudentGrade extends Model
{
    use HasFactory;
    protected $table ='students_grades';
    protected $primaryKey = 'grade_id';

    protected $fillable =[
        'prelim',
        'midterm',
        'finals',
        'completion',
        'final_grade',
        'equivalent',
        'remarks',
        'course_id',
        'ay_id',
        'sem_id',
        'stud_id',
        'sched_id'
    ];

    protected $hidden = [
        'grade_id',
        'stud_id'
    ];

    public $timestamps = false;

    public function stud_info()
    {
        return $this->belongsTo(Student::class,'stud_id','stud_id')->select(['stud_id','fname','lname','mname']);
    }
}
