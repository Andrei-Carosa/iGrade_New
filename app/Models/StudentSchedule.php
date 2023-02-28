<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class StudentSchedule extends Model
{
    use HasFactory;
    protected $table ='students_schedule';
    protected $primaryKey = 'ss_id';

    protected $hidden = [
        'ss_id',
        'sched_id',
    ];

    public function stud_info(){
        return $this->belongsTo(Student::class,'stud_id','stud_id')->select(['stud_id','fname','mname','lname']);
    }

    public function stud_lms_submission(){
        return $this->belongsTo(ScheduleActivity::class,'sched_id','sched_id')->select(['post_id','sched_id']);
    }
}
