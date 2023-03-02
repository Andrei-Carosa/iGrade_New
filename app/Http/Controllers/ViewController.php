<?php

namespace App\Http\Controllers;

use App\Events\ViewFRS;
use App\Models\iGradeColumn;
use App\Models\iGradeImport;
use App\Models\iGradeScores;
use App\Models\LmsPostSubmission;
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

        $sched_id = 12970;
        $category = 0;

        $class = Schedule::with('sched_course','sched_blocking.block')->where('sched_id',$sched_id)->first(['sched_id','course_id']);
        $stud_sched = StudentSchedule::with('stud_info')->where('sched_id',$sched_id)->get('stud_id');
        $postId = iGradeImport::with('import_lms')->where([['sched_id',$sched_id],['category',$category]])->pluck('post_id');
        $import = iGradeImport::with(['import_lms','import_lms_submitted'])->where([['sched_id',$sched_id],['category',$category]])->get();
        $column = iGradeColumn::with('column_score')->where([['sched_id',$sched_id],['type',$category]])->get();
        $column_score = iGradeScores::whereIn('col_id',$column)->get();

        $student_score = array();
        $score_column = array();
        $score_import = array();

        $percent_type = $this->tab_index_percentage(0);

        if(!empty($import) || !empty($column)){

            $lms_submission = LmsPostSubmission::whereIn('post_id',$postId)->get(['stud_id','score','post_id']);

            foreach($stud_sched as $stud_key => $students){

                $total_import_score = 0;
                $total_column_score = 0;

                $total_import_hps = 0;
                $total_column_hps = 0;

                $calculated_score = 0;

                //import
                foreach($import as $key_import => $imports){

                    // $filtered_array = array_filter($lms_submission, function($val) use($students,$imports){
                    //     return ($val['stud_id']==$students->stud_id and $val['post_id']==$imports->post_id);
                    // });

                    $filtered_array = $imports->import_lms_submitted->where('stud_id',$students->stud_id)->all();

                    if( !empty($filtered_array) ) {
                        foreach($filtered_array as $submission_score){
                            echo $imports->post_id;
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

                    if($students->stud_id == $columns->column_score->stud_id){
                        $score_column["column_$key_column"] = $columns->column_score->score;
                        $total_column_score = $total_column_score+$score_column["column_$key_column"];
                    }else{
                        $score_column["column_$key_column"] = 0;
                    }

                    $total_column_hps = $total_column_hps+$columns->column_score->hps;

                }

                if( ($total_import_hps != 0 || $total_column_hps !=0) ){
                    $calculated_score = (((($total_import_score+$total_column_score) / ($total_import_hps+$total_column_hps)) * $percent_type)*100);
                }

                $student_score[$stud_key] = array('name'=> $students->stud_info->fullname,'stud_id'=> $students->stud_id,'total_score'=>$total_import_score+$total_column_score,'calculated_score'=>$calculated_score);
                $student_score[$stud_key] = array_merge($student_score[$stud_key],$score_import);
                $student_score[$stud_key] = array_merge($student_score[$stud_key],$score_column);

            }
        }

return $student_score;
        // return view('college.page.myclass');

    }
}
