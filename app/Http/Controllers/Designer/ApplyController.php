<?php

namespace App\Http\Controllers\Designer;

use App\Http\Controllers\Controller;
use App\Models\Apply;
use App\Models\Otp;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use Exception;
use Illuminate\Support\Carbon;

class ApplyController extends Controller
{
    public function apply_now(Request $request)
    {
        if ($_POST) {
            $request->validate([
                'mobilenumber' => 'required|numeric|digits:10',
            ]);
            Otp::where('contact', $request->mobilenumber)->delete();
            $otp = mt_rand(1000, 9999);
            $data = new Otp;
            $data->contact = $request->mobilenumber;
            $data->otp = $otp;
            $data->save();
            $request->session()->put($request->_token, $data);
            $ip = $request->session()->get($request->ip());
            return redirect()->route('get_otp');
        }
        return view('designer.login.apply');
    }
    public function verify(Request $request)
    {
        return redirect()->route('form');

        $request->validate([
            'otp' => 'required|numeric|digits:4',
            'phonenumber' => 'required|numeric|digits:10'
        ]);
        $current = Carbon::now();
        $data = Otp::where('contact', $request->phonenumber)->first();
        if ($data) {
            if ($current->diffInMinutes($data->updated_at) > 2) {
                return redirect()->back()->with('msg', "OTP Timeout..!");
            } else if ($data->otp == $request->otp) {
                return redirect()->route('form');
            } else {
                return redirect()->back()->with('msg', 'Invalid OTP');
            }
        }
    }
    public function get_otp(request $request)
    {
        return view('designer.login.apply_otp');
    }

    public function form(Request $request)
    {
        if ($_POST) {
            $request->validate([
                'name' => 'required|string|min:2|max:255',
                'email' => 'required|string|email|max:255|regex:/^([a-z0-9\+_\-]+)(\.[a-z0-9\+_\-]+)*@([a-z0-9\-]+\.)+[a-z]{2,6}$/ix',
                'facebook' => 'required_without_all:instagram,pintrest,behance,dribble',
                'instagram' => 'required_without_all:facebook,pintrest,behance,dribble',
                'pintrest' => 'required_without_all:facebook,instagram,behance,dribble',
                'behance' => 'required_without_all:facebook,instagram,pintrest,dribble',
                'dribble' => 'required_without_all:facebook,instagram,pintrest,behance',
            ]);
            $data = new Apply;
            $data->name = $request->name;
            $data->email = $request->email;
            if ($request->facebook) {
                $data->facebook = $request->facebook;
            }
            if ($request->facebook) {
                $data->facebook = $request->facebook;
            }
            if ($request->instagram) {
                $data->instagram = $request->instagram;
            }
            if ($request->pintrest) {
                $data->pintrest = $request->pintrest;
            }
            if ($request->behance) {
                $data->behance = $request->behance;
            }
            if ($request->dribble) {
                $data->dribble = $request->dribble;
            }
            if ($request->portfolio) {
                $data->link = $request->portfolio;
            }
            if ($request->referal) {
                $data->referalcode = $request->referal;
            }
            // return $data;
            $data->save();
        }
        $current = Carbon::now();
        $data = $request->session()->get($request->ip());
        if ($data) {
            if ($current->diffInMinutes($data->updated_at) > 5) {
                $request->session()->forget($request->ip());
                return redirect()->route('apply_now');
            } else {
                return view('designer.apply_form');
            }
        } else {
            return redirect()->route('apply_now');
        }
    }

    public function resend(Request $request)
    {
        $otp = mt_rand(1000, 9999);
        Otp::where('contact', $request->phone)->update(['otp' => $otp]);
        return;
    }
}
