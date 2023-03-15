<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class main extends Controller
{
    function loadView(){
        return view('main');
    }
}
