<?php

namespace App\Listeners;

use App\Events\ViewClassRecord;
use App\Models\iGradeLab;
use App\Models\iGradeLecture;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Queue\InteractsWithQueue;

class AddClassRecordGrade
{
    /**
     * Create the event listener.
     *
     * @return void
     */
    public function __construct()
    {
        //
    }

    /**
     * Handle the event.
     *
     * @param  object  $event
     * @return void
     */
    public function handle(ViewClassRecord $event)
    {
        $sched_id = $event->sched_id;
        $term_id = $event->term_id;
        $p_id = $event->p_id;
        $stud_sched = $event->stud_sched;
        $student_lec = array();
        $student_lab = array();
        $lec = $event->lec;
        $lab = $event->lab;
        $sched_type = array();

        foreach($stud_sched as $key => $students){

            $student_lec[$key] = array(
                'sched_id'=>$sched_id,
                'term_id'=>$term_id,
                'p_id'=>$p_id,
                'stud_id'=>$students,
                'cp'=>0,
                'quiz'=>0,
                'others'=>0,
                'exam'=>0,
            );

            $student_lab[$key] = array(
                'sched_id'=>$sched_id,
                'term_id'=>$term_id,
                'p_id'=>$p_id,
                'stud_id'=>$students,
                'cp'=>0,
                'exercise'=>0,
                'exam'=>0,
            );

        }

        if($lec === 0){
            iGradeLecture::insert($student_lec);
        }

        if($lab === 0){
            iGradeLab::insert($student_lab);
        }

    }
}
