<?php

namespace App\Http\Controllers;

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
// use Illuminate\Contracts\View\View;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Response;
use Illuminate\Support\Facades\View;
use Throwable;

class ViewController extends Controller
{
    public function my_class()
    {

    // $sched_id = 13187;
        // $category = 0;
        // $term = 1;

        // $stud_sched = StudentSchedule::with('stud_info')->where('sched_id',$sched_id)->get('stud_id');
        // $import = iGradeImport::with(['import_lms','import_lms_submitted'])->where([['sched_id',$sched_id],['category',$category],['term',$term]])->get();
        // $column = iGradeColumn::with('column_score')->where([['sched_id',$sched_id],['type',$category],['term',$term]])->get();

        // $student_score = array();
        // $score_column = array();
        // $score_import = array();

        // $percent_type = $this->tab_index_percentage($category);

        // if( count($import) >=1 || count($column)>=1 ){

        //     foreach($stud_sched as $stud_key => $students){

        //         $total_import_score = 0;
        //         $total_column_score = 0;

        //         $total_import_hps = 0;
        //         $total_column_hps = 0;

        //         $calculated_score = 0;

        //         //import
        //         foreach($import as $key_import => $imports){

        //             $filtered_array = $imports->import_lms_submitted->where('stud_id',$students->stud_id)->all();

        //             if( !empty($filtered_array) ) {
        //                 foreach($filtered_array as $submission_score){
        //                     $score_import["import_$key_import"] = $submission_score->score== null ? 0 :$submission_score->score;
        //                     $total_import_score = $total_import_score+$score_import["import_$key_import"];
        //                 }
        //             }else{
        //                 $score_import["import_$key_import"] = 0 ;
        //             }

        //             $total_import_hps = $total_import_hps+ $imports->import_lms->hps;
        //         }

        //         //column
        //         foreach($column as $key_column => $columns){

        //             foreach($columns->column_score as $column_score){

        //                 if($students->stud_id == $column_score->stud_id){
        //                     $score_column["column_$key_column"] = $column_score->score;
        //                     $total_column_score = $total_column_score+$column_score->score;
        //                     break;
        //                 }else{
        //                     $score_column["column_$key_column"] = 0;
        //                 }
        //             }

        //             $total_column_hps = $total_column_hps+$columns->hps;

        //         }


        //         if( ($total_import_hps != 0 || $total_column_hps !=0) ){
        //             $calculated_score = (((($total_import_score+$total_column_score) / ($total_import_hps+$total_column_hps)) * $percent_type)*100);
        //         }


        //         $student_score[$stud_key] = array('name'=> $students->stud_info->fullname,'stud_id'=> $students->stud_id,'total_score'=>$total_import_score+$total_column_score,'calculated_score'=>$calculated_score);
        //         $student_score[$stud_key] = array_merge($student_score[$stud_key],$score_import);
        //         $student_score[$stud_key] = array_merge($student_score[$stud_key],$score_column);

        //     }
        //    return $total_all_hps = $total_column_hps+$total_import_hps;

            // $grading_sheet_tbl=base64_encode(View::make("college.render.table-grading_sheet",compact('student_score','import','column'))->render());
            // $response = Response::json(['success' =>'success'],200);

    // }


        $sched_id = 13187;
        $ay_id = 20;
        $sem_id = 2;
        $schedule = Schedule::find($sched_id,['grades_submit']);
        $teacher_sched =ScheduleTeacher::where('sched_id',$sched_id)->count();

        $grade_1 = null;
        $grade_2 = null;

        $sys_term = iGradeTerm::all(['term_id']);
        $stud_grade = StudentGrade::where([['ay_id',$ay_id],['sem_id',$sem_id],['sched_id',$sched_id]])->count();
        $stud_sched = StudentSchedule::where([['sched_id',$sched_id]])->get();

        $stud_frs = array();

        if($schedule->grades_submit == 0){

            foreach($stud_sched as $stud_key => $stud_scheds){

                $stud_frs[$stud_key] = array('stud_id'=>$stud_scheds->stud_id);

                foreach($sys_term as $term){

                    $cp_lec=0;
                    $quiz_lec=0;
                    $others_lec=0;
                    $exam_lec=0;

                    $cp_lab=0;
                    $exercise_lab=0;
                    $exam=0;
                    $total_lec =0;
                    $total_lab =0;

                    $term_grade =0;
                    $grade_fg = 0;


                    if($teacher_sched > 1){

                        $lec = iGradeLecture::where([['sched_id',$sched_id],['term_id',$term->term_id]])->get(['stud_id','cp','quiz','others','exam'])->toArray();
                        $lab = iGradeLab::where([['sched_id',$sched_id],['term_id',$term->term_id]])->get(['stud_id','cp','exercise','exam'])->toArray();

                        if($lec >=1 && $lab >=1){

                            $lec_key = array_keys(array_column($lec, 'stud_id'), $stud_scheds->stud_id);
                            $lab_key = array_keys(array_column($lab, 'stud_id'), $stud_scheds->stud_id);

                            if(count($lec_key) >=1 ){
                                $cp_lec = $lec[$lec_key[0]]['cp'];
                                $quiz_lec = $lec[$lec_key[0]]['quiz'];
                                $others_lec = $lec[$lec_key[0]]['exercise'];
                                $exam_lec = $lec[$lec_key[0]]['exam'];

                                $total_lec = (($cp_lec+$quiz_lec+$others_lec+$exam_lec)*0.6);
                            }

                            if(count($lab_key) >=1 ){
                                $cp_lab = [$lab_key[0]]['cp'];
                                $exercise_lab = [$lab_key[0]]['exercise'];
                                $exam_lab = [$lab_key[0]]['exam'];

                                $total_lab = (($cp_lab+$exercise_lab+$exam_lab)*0.4);

                            }

                            if($term->term_id == 1){
                                $grade_fg = $grade_fg+(($total_lec+$total_lab)*0.30);
                                $term_grade = array('prelim'=>$total_lec+$total_lab);
                            }elseif($term->term_id == 2){
                                $grade_fg = $grade_fg+(($total_lec+$total_lab)*0.30);
                                $term_grade = array('midterm'=>$total_lec+$total_lab);
                            }elseif($term->term_id == 2){
                                $grade_fg = $grade_fg+(($total_lec+$total_lab)*0.40);
                                $term_grade = array('midterm'=>$total_lec+$total_lab);
                            }


                        }

                    }

                }

                $stud_frs[$stud_key] = array_push($stud_frs[$stud_key],$term_grade);
            }

        }elseif($schedule->grades_submit == 1){

        }

    return 1;
    return view('college.page.myclass');




    }
}
