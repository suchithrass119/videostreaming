<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class LoginManager extends Controller
{
    public function index()
    {
        return view('login') ;
    }
}
