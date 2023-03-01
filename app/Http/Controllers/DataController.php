<?php

namespace App\Http\Controllers;

use App\Models\iGradeTerm;
use App\Models\ScheduleTeacher;
use App\Models\StudentGrade;
use App\Models\SystemSetting;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\View;
use Illuminate\Support\Facades\Response;
use Throwable;

class DataController extends Controller
{

    protected $p_id;
    protected $sys_setting;
    protected $sys_term;

    public function __construct()
    {
        $this->middleware('auth');
        $this->middleware(function ($request, $next) {

            $this->p_id = Auth::user()->p_id;
            $this->sys_setting = SystemSetting::where( 'system_title', Auth::user()->is_shs == 0 ?'grading-college': 'grading-shs' )->first();
            return $next($request);

        });

        $this->sys_term = iGradeTerm::active()->first(['term_id','term']);

    }

    public function my_class_fetch() {

        $class = ScheduleTeacher::with(['teacher_sched.sched_course','teacher_sched.sched_blocking.block'])->withCount(['sched_lms_post as activity_count'])
        ->whereHas('teacher_sched', function ($query){
            $query->where([['sem_id',$this->sys_setting->sem_id],['ay_id',$this->sys_setting->ay_id]]);
        })->where('p_id',$this->p_id)->orderBy('sched_id')->orderBy('type','asc')->get();

        $class = $this->filter_class($class);
        $class = base64_encode(View::make("college.render.card-my_class",compact('class'))->render());

        return Response::json(['success' => 'success','class'=>$class],200);

    }

    public function frs(Request $request){

        try{

            $response = $this->check_request($request);

            if($response != true){
                return $response;
            }

            $sched_id = $this->decrypt_id($request->id);
            $frs = StudentGrade::where([['sched_id',$sched_id],['ay_id',$this->sys_setting->ay_id],['sem_id',$this->sys_setting->sem_id]])->get();
            if($frs){

                $frs = base64_encode(View::make("college.render.modal-frs",compact('frs'))->render());
                $response = Response::json(['success' =>'success','frs'=>$frs],200);

            }else{
                $response = Response::json(['empty' =>'Include your activities and exams before viewing the FRS.'],200);
            }

        } catch(Throwable $e){

            $response = Response::json(['error' =>'Something went wrong. Try again later.'.$e->getMessage()],200);

        }

        return $response;

    }
}
