<?php

namespace App\Http\Controllers;

use App\Models\iGradeTerm;
use App\Models\SystemSetting;
use Illuminate\Foundation\Auth\Access\AuthorizesRequests;
use Illuminate\Foundation\Bus\DispatchesJobs;
use Illuminate\Foundation\Validation\ValidatesRequests;
use Illuminate\Routing\Controller as BaseController;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Response;
use Illuminate\Support\Facades\Validator;

class Controller extends BaseController
{
    use AuthorizesRequests, DispatchesJobs, ValidatesRequests;

    public function sys_setting()
    {
        // $sys_setting = Cache::remember('sys_setting', 86400, function(){
        //      return  $sys_settings = SystemSetting::where( 'system_title', Auth::user()->is_shs == 0 ?'grading-college': 'grading-shs' )->first();
        //  });

        return SystemSetting::where( 'system_title', Auth::user()->is_shs == 0 ?'grading-college': 'grading-shs' )->first();
    }

    public function sys_term()
    {

        return iGradeTerm::active()->first(['term_id','term']);
    }

    public function encrypt_id($id){
        return encrypt($id);
    }

    public function decrypt_id($id){
        return decrypt($id);
    }

    public function check_request($request)
    {
        $response = true;
        $validator = Validator::make($request->all(),[ 'id' => 'required']);

        if( $validator->fails() || !$request->ajax() ){

            $response = Response::json(['error' => 'Missing request id. Try again later'],200);

        }

        return $response;
    }

    public function error_message($type)
    {

        switch($type){
            case 1 :
                $response = 'Oops, Invalid Request Please Try Again';
                break;

            default:
                $response = 'Oops, No Response Please Try Again';
                break;
        }

        return $response;

    }
    public function filter_class($class)
    {
        $sched_count = count($class);

        for ($x=0;$x<$sched_count;$x++){

            for($y=$x+1;$y<$sched_count;$y++){

                if( isset($class[$x]) && isset($class[$y]) ){

                    if ( ($class[$x]->sched_id == $class[$y]->sched_id) && ($class[$x]->p_id == $class[$y]->p_id)  ){

                        $class->forget($x);
                        $class[$y]->type=2;
                        $class[$y]->sched_id=$this->encrypt_id($class[$y]->sched_id);

                    }

                }
            }

        }

        return $class;
    }

    public function tab_index_percentage($tab_index){

        return $tab_index==0?0.10:
        ($tab_index==1?0.20:
        ($tab_index==2?0.20:
        ($tab_index==3?0.50:
        ($tab_index==6?0.50:
        ($tab_index==7?0.70:0.20)))));

    }

    public function tab_name($tab_name){

        return $tab_name==0?'cp':
        ($tab_name==1?'quiz':
        ($tab_name==2?'others':
        ($tab_name==3?'exam':
        ($tab_name==6?'cp':
        ($tab_name==7?'exercise':'exam')))));

    }
}
