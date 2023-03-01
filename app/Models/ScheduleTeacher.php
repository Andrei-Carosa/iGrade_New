<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Casts\EncryptCast;

class ScheduleTeacher extends Model
{
    use HasFactory;
    protected $table ="schedules_teachers";
    protected $primaryKey = 'id';

    protected $hidden = [
        'id',
        // 'sched_id',
        // 'p_id'
    ];

    public function teacher_sched(){
        return $this->belongsTo(Schedule::class,'sched_id','sched_id')->select(['sched_id','course_id','program_id','class_size','grades_submit','class_no']);
    }

    public function teacher_info(){
        return $this->belongsTo(Employee::class,'p_id','p_id');
    }

    public function sched_lms_post(){
        return $this->hasMany(LmsPost::class,'sched_id','sched_id');
    }

    public function getSchedTypeAttribute(){
        return $this->type == 1 ? 'LEC ' : 'LECTURE';
    }

    public function getTeacherScheduleAttribute(){
        return $this->type == 1 ? 'LABORATORY' :( $this->type == 2 ? 'LEC & LAB' : 'LECTURE');
    }
}
