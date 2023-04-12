<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class AdminController extends Controller
{
    function loadView(){
        return view('admin');
    }

    public function voidOrders()
    {
        $users = User::all();
        return view('void-orders', compact('users'));
    }

}
