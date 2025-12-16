<?php

namespace App\Http\Controllers;

use App\User;
// use Dotenv\Validator;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Spatie\Permission\Traits\HasRoles;
use Illuminate\Foundation\Auth\AuthenticatesUsers;
use Illuminate\Foundation\Auth\RegistersUsers;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\Auth;

class LoginController extends Controller
{
    use RegistersUsers;

    public function login(Request $request)
    {
        if ($_POST) {
            $validation = Validator::make($request->all(), [
                'email' => 'required|string|email|max:255|regex:/^([a-z0-9\+_\-]+)(\.[a-z0-9\+_\-]+)*@([a-z0-9\-]+\.)+[a-z]{2,6}$/ix',
                'password' => 'required',
            ]);
            if ($validation->fails()) {
                return response()->json(['status' => '0',  'error' => $validation->errors()->getMessages()], 200);
            }
            $credentials = $request->only('email', 'password');
            if (Auth::attempt($credentials)) {
                return response()->json(['status' => '1'], 200);
            }
            return response()->json(['status' => '0', 'invalid' => 'Invalid Credentials'], 200);
            // return redirect("login")->withSuccess('Oppes! You have entered invalid credentials');
        }
        return view('frontend.login.login');
    }

    public function register(Request $request)
    {
        if ($_POST) {
            // return $request;
            $validation = Validator::make($request->all(), [
                'name' => 'required|string|min:2|max:255',
                'email' => 'required|string|email|max:255|unique:users|regex:/^([a-z0-9\+_\-]+)(\.[a-z0-9\+_\-]+)*@([a-z0-9\-]+\.)+[a-z]{2,6}$/ix',
                'contact' => 'required|numeric|digits:10',
                'password' => 'required|string|min:8'
            ]);
            if ($validation->fails()) {
                return response()->json(['status' => '0', 'message' => 'Validation Error', 'error' => $validation->errors()->getMessages()], 200);
            }

            $data = new User;
            $data->name = $request->name;
            $data->email = $request->email;
            $data->contact = $request->contact;
            $data->password = Hash::make($request->password);
            $data->save();
            $this->guard()->login($data);

            return response()->json(['status' => '1', 'message' => 'Success'], 200);
            // return redirect()->route('home');
        }
        return view('frontend.home');
    }



    public function create(array $data)
    {
        return User::create([
            'name' => $data['name'],
            'email' => $data['email'],
            'contact' => $data['contact'],
            'password' => Hash::make($data['password']),
        ]);
    }


    public function forgot()
    {
        return view('frontend.login.forgot');
    }

    public function reset()
    {
        return view('frontend.login.reset_password');
    }
}