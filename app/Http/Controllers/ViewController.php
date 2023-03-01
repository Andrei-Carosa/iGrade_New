<?php

namespace App\Http\Controllers;

use App\Models\ScheduleTeacher;
use Illuminate\Contracts\View\View;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class ViewController extends Controller
{
    public function my_class()
    {
        return view('college.page.myclass');

    }
}
