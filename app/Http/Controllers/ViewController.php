<?php

namespace App\Http\Controllers;

use App\Events\ViewFRS;
use App\Models\Schedule;
use App\Models\ScheduleTeacher;
use App\Models\StudentGrade;
use App\Models\StudentSchedule;
use Illuminate\Contracts\View\View;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Throwable;

class ViewController extends Controller
{
    public function my_class()
    {
        try{

            // $response = $this->check_request($request);

            // if($response != true){
            //     return $response;
            // }

            $sched_id = 13187;
            $ay_id = 20;
            $sem_id = 2;
            $p_id = Auth::user()->p_id;

            $class = Schedule::with('sched_course','sched_blocking.block')->where('sched_id',$sched_id)->first(['sched_id','course_id']);

            $stud_sched = StudentSchedule::where('sched_id',$sched_id)->pluck('stud_id');
            $frs = StudentGrade::where([['sched_id',$sched_id],['ay_id',$ay_id],['sem_id',$sem_id]])->count();

            if($class) {

                if($frs == 0){
                    event(new ViewFRS($sched_id,$ay_id,$sem_id,$stud_sched,$p_id,$class->course_id));
                    echo 21;
                }
                echo 1;
                // $frs = base64_encode(View::make("college.render.table-frs",compact('class'))->render());
                // $response = Response::json(['success' =>'success','frs'=>$frs],200);

            }else{
                // $response = Response::json(['empty' =>'Something went wrong fetching FRS'],200);
                echo 2;

            }

        } catch(Throwable $e){
            echo $e->getMessage();
            // $response = Response::json(['error' =>'Something went wrong. Try again later.'.$e->getMessage()],200);

        }
return 1;

        return view('college.page.myclass');

    }
}
