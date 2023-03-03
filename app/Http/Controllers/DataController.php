<?php

namespace App\Http\Controllers;

use App\Events\AddColumn;
use App\Events\ViewClassRecord;
use App\Events\ViewFRS;
use App\Models\iGradeColumn;
use App\Models\iGradeImport;
use App\Models\iGradeLab;
use App\Models\iGradeLecture;
use App\Models\iGradeScores;
use App\Models\iGradeTerm;
use App\Models\LmsPost;
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

            $stud_array = array();
            $sched_id = $this->decrypt_id($request->id);
            $schedule = Schedule::find($sched_id,['grades_submit']);
            $stud_grade = StudentGrade::where([['ay_id',$this->sys_setting->ay_id],['sem_id',$this->sys_setting->sem_id],['sched_id',$sched_id]])->count();

            if($stud_grade == 0 ){
                $stud_sched = StudentSchedule::where('sched_id',$sched_id)->pluck(['stud_id']);

            }else{
                $frs = DB::table('students_grades')->select([
                    'stud_id','prelim','midterm','finals','equivalent','final_grade','remarks','grade_id',
                    DB::raw("(select CONCAT(lname,', ',fname) from students WHERE stud_id = students_grades.stud_id order by lname ASC) as fullname"),
                ])->where([['sched_id',$sched_id],['ay_id',$this->sys_setting->ay_id],['sem_id',$this->sys_setting->sem_id]]);
            }


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

    public function fetch_frs(Request $request)
    {
        try{

            $response = $this->check_request($request);

            if($response != true){
                return $response;
            }

            $stud_array = array();
            $sched_id = $this->decrypt_id($request->id);
            $schedule = Schedule::find($sched_id,['grades_submit']);
            $teacher_sched =ScheduleTeacher::where('sched_id',$sched_id)->pluck('type');

            $grade_1 = null;
            $grade_2 = null;

            $sys_term = iGradeTerm::all(['term_id']);

            $stud_grade = StudentGrade::where([['ay_id',$this->sys_setting->ay_id],['sem_id',$this->sys_setting->sem_id],['sched_id',$sched_id]])->count();
            $stud_sched = StudentSchedule::where([['sched_id',$sched_id]])->get();

            if($schedule->grades_submit == 0){

                foreach($stud_sched as $stud_scheds){

                    foreach($sys_term as $term){

                        if(count($teacher_sched) > 1){

                            $lec = iGradeLecture::where([['sched_id',$sched_id],['term',$term->term_id]])->get(['stud_id','cp','quiz','others','exam'])->toArray();
                            $lab = iGradeLab::where([['sched_id',$sched_id],['term',$term->term_id]])->get(['stud_id','cp','exercise','exam'])->toArray();

                            if($lec >=1 && $lab >=1){

                                $lec_filtered = array_keys(array_column($lec, 'stud_id'), $stud_scheds->stud_id);
                                $lab_filtered = array_keys(array_column($lab, 'stud_id'), $stud_scheds->stud_id);
                                
                            }

                        }

                    }
                }


            }elseif($schedule->grades_submit == 1){

            }



        } catch (Throwable $e){

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

            $class_record = base64_encode(View::make("college.render.card-class_record",compact('class','lec_grade','lab_grade','term','class_teacher'))->render());
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
            $term = $request->term==1?'PRELIM':($request->term==2?'MIDTERM':'FINALS');

            $class = Schedule::with('sched_course','sched_blocking.block')->where('sched_id',$sched_id)->first(['sched_id','course_id']);

            if($request->sched_type == 0){
                $grading_sheet = base64_encode(View::make("college.render.card-grading_sheet_lec",compact('class','term'))->render());
            }elseif($request->sched_type ==1){
                $grading_sheet = base64_encode(View::make("college.render.card-grading_sheet_lab",compact('class','term'))->render());
            }

            $response = Response::json(['success' =>'success','grading_sheet'=>$grading_sheet],200);

        } catch(Throwable $e){

            $response = Response::json(['error' => $e->getMessage()],400);
        }

        return $response;

    }

    public function tbl_grading_sheet(Request $request)
    {

        try{

            $sched_id = $this->decrypt_id($request->id);

            $stud_sched = StudentSchedule::with('stud_info')->where('sched_id',$sched_id)->get();
            $import = iGradeImport::with(['import_lms','import_lms_submitted'])->where([['sched_id',$sched_id],['category',$request->category],['term',$request->term]])->get();
            $column = iGradeColumn::with('column_score')->where([['sched_id',$sched_id],['type',$request->category],['term',$request->term]])->get();

            $student_score = array();
            $score_column = array();
            $score_import = array();

            $total_all_hps = 0;
            $total_import_hps = 0;
            $total_column_hps = 0;
            $percent_type = $this->tab_index_percentage($request->category);
            $type_name = $this->tab_name($request->category);

            if( count($import) >=1 || count($column)>=1 ){

                foreach($stud_sched as $stud_key => $students){

                    $total_import_score = 0;
                    $total_column_score = 0;

                    $total_import_hps = 0;
                    $total_column_hps = 0;

                    $calculated_score = 0;

                    //import
                    foreach($import as $key_import => $imports){

                        $filtered_array = $imports->import_lms_submitted->where('stud_id',$students->stud_id)->all();

                        if( !empty($filtered_array) ) {
                            foreach($filtered_array as $submission_score){
                                $score_import["import_$key_import"] = $submission_score->score== null ? 0 :$submission_score->score;
                                $total_import_score = $total_import_score+$score_import["import_$key_import"];
                            }
                        }else{
                            $score_import["import_$key_import"] = 0 ;
                        }

                        $total_import_hps = $total_import_hps+ $imports->import_lms->hps;
                    }

                    //column
                    foreach($column as $key_column => $columns){

                        foreach($columns->column_score as $column_score){

                            if($students->stud_id == $column_score->stud_id){
                                $score_column["column_$key_column"] = $column_score->score;
                                $total_column_score = $total_column_score+$score_column["column_$key_column"];
                                break;
                            }else{
                                $score_column["column_$key_column"] = 0;
                            }

                        }

                        $total_column_hps = $total_column_hps+$columns->hps;

                    }

                    if( ($total_import_hps != 0 || $total_column_hps !=0) ){
                        $calculated_score = (((($total_import_score+$total_column_score) / ($total_import_hps+$total_column_hps)) * $percent_type)*100);
                    }

                    $student_score[$stud_key] = array('name'=> $students->stud_info->fullname,'stud_id'=> $students->stud_id,'total_score'=>$total_import_score+$total_column_score,'calculated_score'=>$calculated_score);
                    $student_score[$stud_key] = array_merge($student_score[$stud_key],$score_import);
                    $student_score[$stud_key] = array_merge($student_score[$stud_key],$score_column);

                }

            }

            $total_all_hps = $total_column_hps+$total_import_hps;
            $grading_sheet_tbl = base64_encode(View::make("college.render.table-grading_sheet",compact('student_score','import','column','total_all_hps','percent_type','type_name'))->render());
            $response = Response::json(['success' =>'success','grading_sheet_tbl'=>$grading_sheet_tbl],200);

        }catch (Throwable $e){

            $response = Response::json(['error' =>'Something went wrong loading class record table.'.$e->getMessage()],400);

        }

        return $response;

    }

    public function add_activity(Request $request)
    {
        try{

            $response = $this->check_request($request);
            if($response != true){
                return $response;
            }

            $sched_id = $this->decrypt_id($request->id);
            $category = $request->category;

            if($request->term == $this->sys_term->term_id){

                $lms_post = LmsPost::where([['term_id',$request->term],['sched_id',$sched_id],['p_id',$this->p_id]])->where(function($query) {
                    return $query->where('type_id',1)->orWhere('type_id',6)->orWhere('type_id',2);
                })->orderBy('type_id','asc')->withCount('submitted_activity')->get();

                $import = IgradeImport::where([['sched_id',$sched_id],['term',$request->term],['p_id',$this->p_id]])->get(['post_id','import_id','category']);

                $modal_activities = base64_encode(View::make("college.render.modal-activities",compact('lms_post','import','category'))->render());
                $response = Response::json(['success'=>'success','modal_activities' => $modal_activities],200);

            }else{

                $response = Response::json(['error'=>'Including of Classwork is open for '.$this->sys_term->term.' only.'],200);

            }


        } catch (Throwable $e){

            $response = Response::json(['error'=>'Something went wrong loading your Activities'.$e->getMessage()],400);

        }

        return $response;

    }

    public function save_added_activity(Request $request)
    {

        try {

            $response = $this->check_request($request);
            $insert = array();

            if($response != true){
                return $response;
            }

            if($request->term == $this->sys_term->term_id){

                $sched_id = $this->decrypt_id($request->id);

                foreach($request->post_id as $post_id){

                    $check_import = IgradeImport::where([['post_id',$post_id],['sched_id',$sched_id],['category',$request->category]])->count();
                    if($check_import == 0){

                        $insert[]=[
                            'sched_id'=>$sched_id,
                            'post_id'=>$post_id,
                            'category'=>$request->category,
                            'p_id'=>$this->p_id,
                            'term'=>$this->sys_term->term_id,
                        ];
                    }

                }

                $import = IgradeImport::insert($insert);
                $response = Response::json(['success'=>'success'],200);

            }else{

                $response = Response::json(['error'=>'Adding of Activities is open for '.$this->sys_term->term.' only.'],200);

            }

        } catch(Throwable $e){

            $response = Response::json(['error' =>'Something went wrong. Try again later.'.$e->getMessage()],200);
        }

        return $response;


    }

    public function remove_activity (Request $request)
    {

        try {

            $response = $this->check_request($request);
            if($response != true){
                return $response;
            }

            $import_id = base64_decode($request->id);
            $clear_import = IgradeImport::destroy($import_id);

            if($clear_import){
                $response = Response::json(['success'=>'success'],200);
            }else{
                $response = Response::json(['error'=>'Something went wrong Removing your Import.'],200);
            }

        } catch(Throwable $e){
            $response = Response::json(['error'=>'Something went wrong Removing your Import.'.$e->getMessage()],400);
        }

        return $response;

    }

    public function add_column(Request $request)
    {

        try {

            $sys_setting=$this->sys_setting();
            $sys_term=$this->sys_term();
            $response = $this->check_request($request);

            if($response != true){
                return $response;
            }

            $sched_id = $this->decrypt_id($request->id);

            if($request->term == $this->sys_term->term_id ){

                    $add_column = new IgradeColumn;
                    $add_column->sched_id = $sched_id;
                    $add_column->term = $request->term;
                    $add_column->type = $request->category;

                    if($add_column->save()){
                        $event = event(new AddColumn($add_column->col_id,$sched_id));

                        if($event){
                            $response = Response::json(['success_add'=>$add_column->col_id],200);
                        }else{
                            $response = Response::json(['error'=>'Something went wrong Adding Column.'],200);
                        }

                    }else{
                        $response = Response::json(['error'=>'Something went wrong Adding Column.'],200);
                    }

            }else{
                $response = Response::json(['error'=>"Adding of column is open for $sys_term->term only"],200);
            }

        } catch (Throwable $e) {
            $response = Response::json(['error'=>'Something went wrong Removing your Import.'.$e->getMessage()],400);
        }

        return $response;

    }

    public function view_column(Request $request)
    {
        try {

            $response = $this->check_request($request);

            if($response != true){
                return $response;
            }

            if($request->term == $this->sys_term->term_id){

                $sched_id = $this->decrypt_id($request->id);

                $column = IgradeColumn::where([['sched_id',$sched_id],['type',$request->category],['term',$this->sys_term->term_id]])->get();
                $import = IgradeImport::where([['sched_id',$sched_id],['category',$request->category]])->count();

                $type = $request->category == 0? 'Class Participation':
                ($request->category == 1? 'Quiz':
                ($request->category == 2? 'Others':
                ($request->category == 3? 'Exam':
                ($request->category == 6? 'Class Participation':
                ($request->category == 7? 'Exercise':'Exam')))));

                $category = $this->tab_name($request->category);

                if(count($column) >= 1){

                    $columns = base64_encode(View::make("college.render.modal-column",compact('column','type','import','category'))->render());
                    $response = Response::json(['success'=>'success','columns'=>$columns],200);

                }elseif(count($column) == 0){

                    $response = Response::json(['empty'=>'Add Column First.'],200);

                }

            }else{

                $response = Response::json(['error'=>'You can only remove column during '.$this->sys_term->term.' only '],200);
            }


        } catch(Throwable $e){

            $response = Response::json(['error'=>'Something went wrong viewing columns. Try again later'.$e->getMessage()],400);

        }

        return $response;
    }

    public function remove_column(Request $request)
    {

        try {

            $response = $this->check_request($request);

            if($response != true){
                return $response;
            }

            $column_id = $request->id;
            $clear_column = IgradeColumn::destroy($column_id);
            $clear_scores = iGradeScores::where('col_id',$column_id)->delete();

            if($clear_column && $clear_scores ){
                $response = Response::json(['success'=>'success'],200);

            }else{
                $response = Response::json(['error'=>'Something went wrong removing column'],200);
            }

        }catch(Throwable $e) {
            $response = Response::json(['error'=>'Something went wrong removing column'.$e->getMessage()],200);
        }

        return $response;
    }

    public function update_column_hps(Request $request)
    {

        try {

            $response = $this->check_request($request);

            if($response != true){
                return $response;
            }

            $column_id = $request->id;
            $update = DB::table('igrade_column')->where('col_id',$column_id)->update(['hps'=>$request->hps]);

            if($update){
                $response = Response::json(['success'=>'success'],200);
            }

        } catch(Throwable $e){
            $response = Response::json(['error'=>'Something went wrong update your column HPS.'.$e->getMessage()],400);
        }

        return $response;

    }

    public function update_column_score(Request $request)
    {

        try {

            $response = $this->check_request($request);

            if($response != true){
                return $response;
            }

            $score_id = $request->id;
            $update = DB::table('igrade_scores')->where('score_id',$score_id)->update(['score'=>$request->score]);

            if($update){
                $response = Response::json(['success'=>'success'],200);
            }

        } catch(Throwable $e){
            $response = Response::json(['error'=>'Something went wrong updating Students Score.'.$e->getMessage()],400);
        }

        return $response;

    }

}
