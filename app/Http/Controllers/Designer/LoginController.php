<?php

namespace App\Http\Controllers\Designer;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class LoginController extends Controller
{
    //
    public function login()
    {
        return view('designer.login.login');
    }
    public function signup()
    {
        return view('designer.signup');
    }
}
