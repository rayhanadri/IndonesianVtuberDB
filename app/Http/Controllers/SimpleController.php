<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class SimpleController extends Controller
{
    //
    function index(){
        return view('auth/register_xyz');
    }
}
