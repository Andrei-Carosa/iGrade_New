<?php

namespace App\Listeners;

use App\Events\AddColumn;
use App\Models\iGradeScores;
use App\Models\StudentSchedule;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Queue\InteractsWithQueue;

class AddColumnScore
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
    public function handle(AddColumn $event)
    {
        $col_id = $event->col_id;

        $sched_id = $event->sched_id;
        $student_sched = array();

        $student = StudentSchedule::where('sched_id',$sched_id)->pluck('stud_id');

        foreach($student as $students){
            $student_sched[] = array(
                'col_id'=>$col_id,
                'stud_id'=>$students,
                'score'=>0,
            );
        }

        if(count($student_sched) >= 1){
            $response = iGradeScores::insert($student_sched);
        }else{
            return false;
        }

        return $response;

    }
}
