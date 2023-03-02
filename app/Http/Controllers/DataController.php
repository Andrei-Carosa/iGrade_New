<?php

namespace App\Http\Controllers;

use App\Events\ViewClassRecord;
use App\Events\ViewFRS;
use App\Models\iGradeColumn;
use App\Models\iGradeImport;
use App\Models\iGradeLab;
use App\Models\iGradeLecture;
use App\Models\iGradeScores;
use App\Models\iGradeTerm;
use App\Models\LmsPostSubmission;
use App\Models\Schedule;
use App\Models\ScheduleTeacher;
use App\Models\StudentGrade;
use App\Models\StudentSchedule;
use App\Models\SystemSetting;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\View;
use Illuminate\Support\Facades\Response;
use Throwable;
use Yajra\DataTables\DataTables;

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

    public function my_class_fetch()
    {

        $class = ScheduleTeacher::with(['teacher_sched.sched_course','teacher_sched.sched_blocking.block'])->withCount(['sched_lms_post as activity_count'])
        ->whereHas('teacher_sched', function ($query){
            $query->where([['sem_id',$this->sys_setting->sem_id],['ay_id',$this->sys_setting->ay_id]]);
        })->where('p_id',$this->p_id)->orderBy('sched_id')->orderBy('type','asc')->get();

        $class = $this->filter_class($class);
        $class = base64_encode(View::make("college.render.card-my_class",compact('class'))->render());

        return Response::json(['success' => 'success','class'=>$class],200);

    }

    public function frs(Request $request)
    {

        try{

            $response = $this->check_request($request);

            if($response != true){
                return $response;
            }

            $sched_id = $this->decrypt_id($request->id);
            $class = Schedule::with('sched_course','sched_blocking.block')->where('sched_id',$sched_id)->first(['sched_id','course_id']);

            $stud_sched = StudentSchedule::where('sched_id',$sched_id)->pluck('stud_id');
            $frs = StudentGrade::where([['sched_id',$sched_id],['ay_id',$this->sys_setting->ay_id],['sem_id',$this->sys_setting->sem_id]])->count();

            if($class) {

                if($frs <= 0){
                    event(new ViewFRS($sched_id,$this->sys_setting->ay_id,$this->sys_setting->sem_id,$stud_sched,$this->p_id,$class->course_id));
                }

                $frs = base64_encode(View::make("college.render.table-frs",compact('class'))->render());
                $response = Response::json(['success' =>'success','frs'=>$frs],200);

            }else{
                $response = Response::json(['empty' =>'Something went wrong fetching FRS'],200);
            }

        } catch(Throwable $e){

            $response = Response::json(['error' =>'Something went wrong. Try again later.'.$e->getMessage()],200);

        }

        return $response;

    }

    public function frs_fetch(Request $request)
    {
        try{

            $response = $this->check_request($request);

            if($response != true){
                return $response;
            }

            $sched_id = $this->decrypt_id($request->id);
            $frs = DB::table('students_grades')->select([
                'stud_id','prelim','midterm','finals','equivalent','final_grade','remarks','grade_id',
                DB::raw("(select CONCAT(lname,', ',fname) from students WHERE stud_id = students_grades.stud_id order by lname ASC) as fullname"),
            ])->where([['sched_id',$sched_id],['ay_id',$this->sys_setting->ay_id],['sem_id',$this->sys_setting->sem_id]]);

            return DataTables::of($frs)
            ->filterColumn('fullname', function($query, $keyword) {
                $sql = "(select CONCAT(lname,', ',fname) from students WHERE stud_id = students_grades.stud_id) like ?";
                $query->whereRaw($sql, ["%{$keyword}%"]);
            })->addColumn('Actions', function($model){
                return $model->grade_id;
            })->rawColumns(['Actions'])->make(true);

        } catch (Throwable $e){

            return Response::json(['error' =>'Something went wrong fetching your FRS.'.$e->getMessage()],200);

        }


    }

    public function frs_student_inc(Request $request)
    {

        try{

            $response = $this->check_request($request);

            if($response != true){
                return $response;
            }

            $grade_id = $this->decrypt_id($request->id);
            $inc = DB::table('students_grades')->where('grade_id',$grade_id)->update([
                'finals' => "INC",
                'final_grade'=> "INC",
                'equivalent'=> "INC",
                'remarks'=> "INC"
            ]);

            if($inc){

                $response =  Response::json(['success' =>'success'],200);

            } else{

                $response =  Response::json(['error' =>'Something went wrong updating the student record.'],200);

            }

        } catch(Throwable $e){

            $response =  Response::json(['error' =>'Something went wrong updating student record.'],400);
        }

        return $response;

    }

    public function class_record_term(Request $request)
    {

        try{

            $response = $this->check_request($request);

            if($response != true){
                return $response;
            }

            $lec_grade = null;
            $lab_grade = null;
            $term = $request->term==1?'PRELIM':($request->term==2?'MIDTERM':'FINALS');

            $sched_id = $this->decrypt_id($request->id);
            $class = Schedule::with('sched_course','sched_blocking.block')->where('sched_id',$sched_id)->first(['sched_id','course_id']);
            $class_teacher = ScheduleTeacher::where([['sched_id',$sched_id],['p_id',$this->p_id]])->pluck('type');

                foreach($class_teacher as $type){

                    if($type ==0){
                        $lec_grade = iGradeLecture::where([['sched_id',$sched_id],['term_id',$request->term]])->count();
                    }elseif($type ==1){
                        $lab_grade = iGradeLab::where([['sched_id',$sched_id],['term_id',$request->term]])->count();
                    }

                }

                if($request->term == $this->sys_term->term_id){
                    if(empty($lec_grade) || empty($lab_grade)){
                        $stud_sched = StudentSchedule::where('sched_id',$sched_id)->pluck('stud_id');
                        event(new ViewClassRecord($sched_id,$this->sys_term->term_id,$this->p_id,$stud_sched,$lec_grade,$lab_grade));
                    }
                }

            $class_record = base64_encode(View::make("college.render.card-class_record",compact('class','lec_grade','lab_grade','term'))->render());
            $response = Response::json(['success' =>'success','class_record'=>$class_record],200);

        } catch (Throwable $e){

            $response =  Response::json(['error' =>'Something went wrong updating student record.'.$e->getMessage()],400);

        }

        return $response;
    }

    public function class_record_tbl(Request $request)
    {

        try{

            $response = $this->check_request($request);

            if($response != true){
                return $response;
            }

            $lec_grade = null;
            $lab_grade = null;

            $sched_id = $this->decrypt_id($request->id);
            $term = iGradeTerm::where('term_id',$request->term)->first(['term_id','term']);
            $class_teacher = ScheduleTeacher::where([['sched_id',$sched_id],['p_id',$this->p_id]])->pluck('type');

            foreach($class_teacher as $type){

                if($type ==0){
                    $lec_grade = iGradeLecture::with('stud_info_lec')->where([['sched_id',$sched_id],['term_id',$request->term]])->get();
                }elseif($type ==1){
                    $lab_grade = iGradeLab::with('stud_info_lab')->where([['sched_id',$sched_id],['term_id',$request->term]])->get();
                }

            }

            $class_record_tbl = base64_encode(View::make("college.render.table-class_record",compact('lec_grade','lab_grade','term'))->render());
            $response = Response::json(['success' =>'success','class_record_tbl'=>$class_record_tbl],200);

        } catch (Throwable $e){

            $response = Response::json(['error' =>'Something went wrong fetching class record.'.$e->getMessage()],400);

        }


        return $response;

    }

    public function class_grading_sheet(Request $request)
    {

        try{

            $response = $this->check_request($request);

            if($response != true){
                return $response;
            }

            $sched_id = $this->decrypt_id($request->id);
            $class = Schedule::with('sched_course','sched_blocking.block')->where('sched_id',$sched_id)->first(['sched_id','course_id']);

            $stud_sched = StudentSchedule::with('stud_info')->where('sched_id',$sched_id)->get('stud_id');
            $import = iGradeImport::with('import_lms')->where([['sched_id',$sched_id],['category',$request->sched_type]])->pluck('post_id');
            $column = iGradeColumn::with('column_score')->where([['sched_id',$sched_id],['type',$request->sched_type]])->get();
            $column_score = iGradeScores::whereIn('col_id',$column)->get();

            $lms_submission = LmsPostSubmission::whereIn('post_id',$import)->get(['stud_id','score','post_id'])->toArray();

            foreach($stud_sched as $students){
                foreach($import as $post_id){

                    $result_key = array_keys($lms_submission, array('stud_id' => $students->stud_id,'post_id' => $post_id));
                    $key = array_search($students->stud_id, array_column($lms_submission, 'stud_id'));

                    if( !empty($result_key) ) {
                        print_r($result_key);
                    }else{
                        echo 'Missing:'.$students->stud_id.'<br>';
                    }
                }
            }
            $grading_sheet = base64_encode(View::make("college.render.card-class_record",compact('stud_sched','import','lab_grade','term'))->render());
            $response = Response::json(['success' =>'success','grading_sheet'=>$grading_sheet],200);

        } catch(Throwable $e){

        }

        return $response;

    }

    public function grading_sheet_tab($type){

    }


}
