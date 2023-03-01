<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Schedule extends Model
{
    use HasFactory;
    protected $primaryKey = 'sched_id';

    protected $hidden = [
        'sched_id',
        'lec_prof',
        'lab_prof',
    ];

    // protected $casts = [
    //     'sched_id' => 'datetime',
    // ];

    public function sched_program(){
        return $this->belongsTo(Program::class,'program_id','program_id')->select(['program_id','description','program_code','college_id']);
    }

    public function sched_course(){
        return $this->belongsTo(Course::class,'course_id','course_id')->select(['course_id','code','description','units']);
    }

    public function sched_year(){
        return $this->belongsTo(AcademicYear::class,'ay_id','ay_id');
    }

    // public function sched_section(){
    //     return $this->hasOne(ScheduleSection::class,'sched_id','sched_id');
    // }

    public function sched_blocking(){
        return $this->hasOne(ScheduleBlocking::class,'sched_id','sched_id')->select(['block_id','sched_id']);
    }

    public function sched_student(){
        return $this->hasMany(StudentSchedule::class,'sched_id','sched_id')->select(['ss_id','sched_id','stud_id']);
    }

    public function sched_sem(){
        return $this->belongsTo(Semester::class,'sem_id','sem_id');
    }

    public function getUploadStatusAttribute(){
        if($this->grades_submit === 0){
            return 'danger';
        }elseif($this->grades_submit == 1){
            return 'success';
        }else{
            return 'secondary';
        }
    }

    public function sched_activity(){
        return $this->hasMany(ScheduleActivity::class,'sched_id','sched_id')->select(['post_id','sched_id','title','details','type_id','is_visible','is_active','posted_at']);
    }

    public function sched_teacher(){
        return $this->hasMany(ScheduleTeacher::class,'sched_id','sched_id');
    }
}
