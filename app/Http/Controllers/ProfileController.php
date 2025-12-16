<?php

namespace App\Http\Controllers;

use Illuminate\Support\Facades\Auth;
use Illuminate\Http\Request;

class ProfileController extends Controller
{
    public function profile()
    {
        return view('frontend.profile.profile');
    }

    public function member()
    {
        return view('frontend.profile.member');
    }
}
