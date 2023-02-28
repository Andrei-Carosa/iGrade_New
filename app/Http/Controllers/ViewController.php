<?php

namespace App\Http\Controllers;

use Illuminate\Contracts\View\View;
use Illuminate\Http\Request;

class ViewController extends Controller
{
    public function my_class():View
    {
        return view('college.page.my-class');

    }
}
