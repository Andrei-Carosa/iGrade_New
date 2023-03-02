<?php

namespace App\Listeners;

use App\Events\ViewFRS;
use App\Models\StudentGrade;

class AddStudentGrade
{
    /**
     * Create the event listener.
     *
     * @return void
     */
    public function __construct()
    {
    }

    /**
     * Handle the event.
     *
     * @param  object  $event
     * @return void
     */
    public function handle(ViewFRS $event)
    {

        $sem_id = $event->sem_id;
        $ay_id = $event->ay_id;
        $sched_id = $event->sched_id;
        $stud_sched = $event->stud_sched;
        $course_id = $event->course_id;
        $p_id = $event->p_id;
        $stud_array = array();

        foreach($stud_sched as $key => $students){

            $stud_array[$key] = array(
                'prelim'=>0,
                'midterm'=>0,
                'finals'=>0,
                'completion'=>null,
                'final_grade'=>0,
                'equivalent'=>0,
                'remarks'=>0,
                'course_id'=>$course_id,
                'p_id'=>$p_id,
                'ay_id'=>$ay_id,
                'sem_id'=>$sem_id,
                'stud_id'=>$students,
                'sched_id'=>$sched_id,
            );

        }
        return StudentGrade::insert($stud_array);
    }
}
