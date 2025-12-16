<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Providers\RouteServiceProvider;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\Hash;
use Illuminate\Foundation\Auth\AuthenticatesUsers;
use Illuminate\Foundation\Auth\RegistersUsers;
use App\Models\User;
use App\Mail\sendEmail;
use Illuminate\Foundation\Auth\EmailVerificationRequest as BaseEmailVerificationRequest;
use Log;
use Illuminate\Support\Facades\Mail;
use Illuminate\Foundation\Auth\EmailVerificationRequest;
use Illuminate\Auth\Events\Verified;
use Illuminate\Foundation\Auth\VerifiesEmails;
use Illuminate\Support\Facades\Auth;
use Illuminate\Auth\Access\AuthorizationException;
use Illuminate\Support\Facades\Storage;
use Twilio\Rest\Client;

class RegisterController extends Controller
{

    public function __construct(Request $request)
    {

        // $validation = Validator::make($request->all(), [
        //     'user_id' => 'required',
        // ]);
        // if ($validation->fails()) {
        //     return response()->json(
        //         [
        //             'status' => '0',
        //             'message' => 'Validation Fails',
        //             'errors' => $validation->errors(),
        //         ],
        //         422,
        //     );
        // }
        // $data = User::find($request->user_id);
        // $this->disable($data);
    }

    public function check(Request $request)
    {
        $validation = Validator::make($request->all(), [
            'device_token' => 'required',
            'user_id' => 'required',
        ]);
        if ($validation->fails()) {
            return response()->json(['status' => '0', 'message' => 'Validation Error', 'error' => $validation->errors()->getMessages()], 400);
        } else {
            $data = User::where('id', $request->user_id)->where('device_token', $request->device_token)->first();
            if ($data) {
                return response()->json(['status' => '1', 'message' => 'Valid Login'], 200);
            } else {
                return response()->json(['status' => '0', 'message' => 'Already logged in another device.'], 200);
            }
        }
    }
    // public function disable($data)
    // {
    //     // return $data;
    //     if ($data->active == '0') {
    //         return response()->json([
    //             'status' => '0',
    //             'message' => 'User Deactived',
    //             'Data' => $data,
    //         ], 200);
    //     } else {
    //         return response()->json([
    //             'status' => '1',
    //             'message' => 'User Actived',
    //             'Data' => $data,
    //         ], 200);
    //     }
    // }

    public function list(Request $request)
    {
        $users = User::orderBy('updated_at', 'DESC')->get();
        if (count($users) > 0) {
            return response()->json(['status' => '1', 'image_url' => asset('public/assets/images/users'), 'message' => 'Users List', 'data' => $users], 200);
        } else {
            return response()->json(['status' => '0', 'message' => 'No User Found'], 200);
        }
    }


    // public function add(Request $request)
    // {
    //     $validation = Validator::make($request->all(), [
    //         'name' => ['required', 'string', 'max:255'],
    //         'company_name' => ['required', 'string', 'max:255'],
    //         'email' => ['required', 'string', 'email', 'max:255', 'unique:users'],
    //         'password' => ['required', 'string', 'min:5', 'confirmed'],
    //         'city' => 'required',
    //         'state' => 'required',
    //         'number' => 'required|numeric|digits:10|unique:users',
    //         'image' => 'required|max:2048|mimes:jpeg,jpg,png',
    //         'device_token' => 'required',
    //         'token' => 'required',
    //         // 'device_id' => 'required',
    //         'device_type' => 'required',

    //     ]);
    //     if ($validation->fails()) {
    //         return response()->json(['status' => '0', 'image_url' => asset('public/assets/images/users'), 'message' => 'Validation Error', 'error' => $validation->errors()->getMessages()], 400);
    //     } else {
    //         $data = new User;
    //         $data->name = $request->name;
    //         $data->company_name = $request->company_name;
    //         $data->email = $request->email;
    //         $data->password = Hash::make($request->password);
    //         $data->city = $request->city;
    //         $data->state = $request->state;
    //         $data->number = $request->number;
    //         $data->device_token = $request->device_token;
    //         $data->token = $request->token;
    //         // $data->device_id = $request->device_id;
    //         $data->device_type = $request->device_type;
    //         if ($request->image) {
    //             $thumb = $request->file('image');
    //             $thumb_file = $this->uploadImage($thumb, '');
    //             $data->image = $thumb_file;
    //         }
    //         $data->save();
    //         $token = $data->createToken('auth-token')->plainTextToken;
    //         // $this->guard()->login($data);

    //         return response()->json(['status' => '1', 'message' => 'User Register successfullyy.', 'data' => $data], 200);
    //     }
    // }


    public function add(Request $request)
    {
        $validation = Validator::make($request->all(), [
            'name' => ['required', 'string', 'max:255'],
            'company_name' => ['required', 'string', 'max:255'],
            'email' => ['required', 'string', 'email', 'max:255', 'unique:users'],
            'password' => ['required', 'string', 'min:5', 'confirmed'],
            'city' => 'required',
            'state' => 'required',
            'number' => 'required|numeric|digits:10|unique:users',
            'image' => 'required|max:2048|mimes:jpeg,jpg,png',
            'device_token' => 'required',
            'token' => 'required',
            'device_type' => 'required',
        ]);

        if ($validation->fails()) {
            return response()->json([
                'status' => '0',
                'image_url' => asset('public/assets/images/users'),
                'message' => 'Validation Error',
                'error' => $validation->errors()->getMessages()
            ], 400);
        }

        try {
            // ✅ 1. Generate OTP
            $otp = rand(1000, 9999);

            // ✅ 2. Create user
            $data = new User;
            $data->name = $request->name;
            $data->company_name = $request->company_name;
            $data->email = $request->email;
            $data->password = Hash::make($request->password);
            $data->city = $request->city;
            $data->state = $request->state;
            $data->number = $request->number;
            $data->device_token = $request->device_token;
            $data->token = $request->token;
            $data->device_type = $request->device_type;
            $data->otp = $otp; // store OTP
            $data->status = '0'; // keep inactive until verified

            if ($request->image) {
                $thumb = $request->file('image');
                $thumb_file = $this->uploadImage($thumb, '');
                $data->image = $thumb_file;
            }

            $data->save();

            // ✅ 3. Send OTP via Twilio
            $sid = env('TWILIO_SID');
            $token = env('TWILIO_AUTH_TOKEN');
            $from = env('TWILIO_PHONE'); // your Twilio number like +12402023290

            $client = new Client($sid, $token);
            $client->messages->create(
                '+91' . $request->number, // assuming Indian numbers
                [
                    'from' => $from,
                    'body' => "Your OTP for registration is: {$otp}"
                ]
            );

            // ✅ 4. Return success
            return response()->json([
                'status' => '1',
                'message' => 'User registered successfully. OTP sent to your mobile number.',
                'data' => $data
            ], 200);
        } catch (\Exception $e) {
            return response()->json([
                'status' => '0',
                'message' => 'Something went wrong',
                'error' => $e->getMessage()
            ], 500);
        }
    }



    public function verifyOtp(Request $request)
    {
        $validation = Validator::make($request->all(), [
            'number' => 'required|numeric|digits:10',
            'otp' => 'required|numeric|digits:4',
        ]);

        if ($validation->fails()) {
            return response()->json([
                'status' => '0',
                'message' => 'Validation Error',
                'error' => $validation->errors()->getMessages()
            ], 400);
        }

        // Find user by number
        $user = User::where('number', $request->number)->first();

        if (!$user) {
            return response()->json([
                'status' => '0',
                'message' => 'User not found with this number.'
            ], 404);
        }

        // Check OTP
        if ($user->otp == $request->otp) {
            $user->status = 0; // mark verified
            $user->otp = null; // clear OTP once verified
            $user->save();

            // Generate auth token
            $token = $user->createToken('auth-token')->plainTextToken;

            return response()->json([
                'status' => '1',
                'message' => 'OTP verified successfully. Registration completed wait for your verification.',
                'data' => $user,
                'token' => $token
            ], 200);
        } else {
            return response()->json([
                'status' => '0',
                'message' => 'Invalid OTP, please try again.'
            ], 400);
        }
    }



    public function uploadImage($file, $dir)
    {
        $extension = $file->getClientOriginalExtension();

        $name = $file->getClientOriginalName();

        $filename =  str_replace(' ', '-', $file->getClientOriginalName());

        $file->move("public/assets/images/users/", $filename);

        return $filename;
    }

    // public function login(Request $request)
    // {
    //     $validator = Validator::make($request->all(), [
    //         'number' => 'required',
    //         'password' => 'required',
    //         'device_token' => 'required',
    //         // 'token' => 'required',
    //         // 'device_id' => 'required',
    //         // 'device_type' => 'required',

    //     ]);

    //     if ($validator->fails()) {
    //         return response()->json([
    //             'message' => 'Validation fails',
    //             'status' => '0',
    //             'errors' => $validator->errors()
    //         ], 422);
    //     }
    //     // $data = User::where('number', $request->number)->where('device_token', $request->device_token)->first();
    //     // if ($data->status == '0') {
    //     //     return response()->json(['status' => '0', 'message' => 'Please contact admin.'], 200);
    //     // }

    //     // $user = User::where('number', $request->number)->where('device_token', $request->device_token)->first();
    //     // $user = User::where('number', $request->number)->whereNull('device_token')->where('status', '1')->first();
    //     $user = User::where('number', $request->number)->first();

    //     if ($user) {
    //         if ($user->status == '1' &&  (!$user->device_token || $user->device_token == $request->device_token)) {
    //             if (Hash::check($request->password, $user->password)) {
    //                 $token = $user->createToken('token')->plainTextToken;
    //                 $user->device_token = $request->device_token;
    //                 $user->save();
    //                 // $this->guard()->login($user);

    //                 return response()->json([
    //                     'status' => '1',
    //                     'message' => 'Login Successfull',
    //                     'token' => $token,
    //                     'image_url' => asset('public/assets/images/users'),
    //                     'data' => $user
    //                 ], 200);
    //             } else {
    //                 return response()->json([
    //                     'status' => '0',
    //                     'message' => 'Invalid Login Details'
    //                 ], 400);
    //             }
    //         } elseif ($user->status == '1' && $user->device_token != $request->device_token) {
    //             return response()->json(['status' => '0', 'message' => 'Already login from another device.'], 200);
    //         } else {
    //             return response()->json(['status' => '0', 'message' => 'For Activation, Call +91-9925823290. Thankyou'], 200);
    //         }
    //     } else {
    //         return response()->json(['status' => '0', 'message' => 'Please contact +91-9925823290 Thank you.'], 200);
    //     }
    // }


    public function login_old(Request $request)
    {
        // Validate the incoming request
        $validator = Validator::make($request->all(), [
            'number' => 'required',
            'password' => 'required',
            'device_token' => 'required',
        ]);

        // Handle validation failures
        if ($validator->fails()) {
            return response()->json([
                'message' => 'Validation failed',
                'status' => '0',
                'errors' => $validator->errors()
            ], 422);
        }

        // Check if the user exists
        $user = User::where('number', $request->number)->first();

        if (!$user) {
            return response()->json([
                'status' => '0',
                'message' => 'User not found. Please contact support.'
            ], 404);
        }

        // Check user status and device token conditions
        if ($user->status == '1') {
            // Verify password
            if (Hash::check($request->password, $user->password)) {
                // Revoke all previous tokens
                $user->tokens()->delete();

                // Generate a new token
                $token = $user->createToken('token')->plainTextToken;

                // Update the device token
                // $user->device_token = $request->device_token;
                $user->token = $request->token;
                $user->save();

                return response()->json([
                    'status' => '1',
                    'message' => 'Login successful',
                    'token' => $token,
                    'image_url' => asset('public/assets/images/users'),
                    'data' => $user
                ], 200);
            }

            return response()->json([
                'status' => '0',
                'message' => 'Invalid login details'
            ], 401);
        }

        // Handle inactive users
        return response()->json([
            'status' => '0',
            'message' => 'Account inactive. Please contact support.'
        ], 200);
    }

 public function login(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'number' => 'required',
            'password' => 'required',
            //'device_token' => 'required'
        ]);

        if ($validator->fails()) {
            return response()->json([
                'status' => '0',
                'message' => 'Validation failed',
                'errors' => $validator->errors()
            ], 422);
        }

        $user = User::where('number', $request->number)->first();

        if (!$user) {
            return response()->json([
                'status' => '0',
                'message' => 'User not found. Please contact support.'
            ], 200);
        }

        if ($user->status != '1') {
            return response()->json([
                'status' => '0',
                'message' => 'Account inactive. Please contact support.'
            ], 200);
        }

        if (!Hash::check($request->password, $user->password)) {
            return response()->json([
                'status' => '0',
                'message' => 'Invalid login details'
            ], 401);
        }

        // ✅ If first time login from device → Save device_token
        if (!$user->device_token) {
            $user->device_token = $request->device_token;
            $user->save();
        }

        // ✅ If logged in previously with some other device → Block
        elseif ($user->device_token != $request->device_token) {
            return response()->json([
                'status' => '0',
                'message' => 'Already logged in from another device.'
            ], 200);
        }

        // ✅ Remove old access tokens and generate a new one
        $user->tokens()->delete();
        $token = $user->createToken('token')->plainTextToken;

        return response()->json([
            'status' => '1',
            'message' => 'Login successful',
            'token' => $token,
            'image_url' => asset('public/assets/images/users'),
            'device_token' => $user->device_token, // ✅ send saved device token only
            'data' => $user
        ], 200);
    }



    public function logout(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'user_id' => 'required',
        ]);

        if ($validator->fails()) {
            return response()->json([
                'message' => 'Validation fails',
                'status' => '0',
                'errors' => $validator->errors()
            ], 422);
        }
        $data = User::find($request->user_id);
        // $data->status = '0';
        $data->device_token = NULL;
        $data->save();
        return response()->json(
            ['status' => '1', 'message' => 'Logged out successfullyy',]
        );
        // if ($request->user()) {
        //     $user = Auth::user()->token();
        //     $user->revoke();
        // }
        // return response()->json(
        //     ['status' => '1', 'message' => 'Logged out successfullyy',]
        // );
    }


    public function requestOtp(Request $request)
    {
        $otp = rand(1000, 9999);
        Log::info("otp = " . $otp);
        $user = User::where('email', '=', $request->email)->update(['otp' => $otp]);

        if ($user) {
            $mail_details = [
                'subject' => 'Testing Application OTP',
                'body' => 'Your OTP is : ' . $otp
            ];
            // \Mail::to($request->email)->send(new sendEmail($mail_details));
            return response(["status" => 1, "message" => "OTP sent successfully"]);
        } else {
            return response(["status" => 0, 'message' => 'Email not found']);
        }
    }



    public function disable(Request $request)
    {

        $validation = Validator::make($request->all(), [
            'user_id' => 'required',
        ]);
        if ($validation->fails()) {
            return response()->json(
                [
                    'status' => '0',
                    'message' => 'Validation Fails',
                    'errors' => $validation->errors(),
                ],
                422,
            );
        }
        //
        $user = User::find($request->user_id);
        // return $user;
        if ($user->status == '0') {
            return response()->json([
                'status' => '0',
                'message' => 'User Deactivated',
                // 'Data' => $user,
            ], 201);
        } else {
            return response()->json([
                'status' => '1',
                'message' => 'User Activated',
                'Data' => $user,
            ], 201);
        }
    }

    public function update(Request $request)
    {
        // Validate the input data
        $validator = Validator::make($request->all(), [
            'user_id' => 'required|exists:users,id',
            'name' => 'nullable|string|max:255',
            'company_name' => 'nullable|string|max:255',
            'email' => 'nullable|email|unique:users,email,' . $request->user_id,
            'city' => 'nullable|string|max:255',
            'number' => 'nullable|string|max:15',
            'image' => 'nullable|image|max:2048', // Max 2MB
        ]);

        if ($validator->fails()) {
            return response()->json([
                'status' => false,
                'message' => 'Validation failed',
                'errors' => $validator->errors(),
            ], 422);
        }

        // Retrieve the user by ID
        $user = User::find($request->user_id);

        try {
            // Update fields
            if ($request->has('name')) $user->name = $request->name;
            if ($request->has('company_name')) $user->company_name = $request->company_name;
            if ($request->has('email')) $user->email = $request->email;
            if ($request->has('city')) $user->city = $request->city;
            if ($request->has('number')) $user->number = $request->number;

            // Handle image upload
            if ($request->image) {
                $thumb = $request->file('image');
                $thumb_file = $this->uploadImage($thumb, '');
                $user->image = $thumb_file;
            }

            // Save the user
            $user->save();

            // Dynamically hide specific attributes
            $user->makeHidden(['otp', 'status', 'device_token', 'device_key', 'token', 'device_type', 'admin']);

            return response()->json([
                'status' => true,
                'message' => 'Profile updated successfully',
                'image_url' => asset('public/assets/images/users'),
                'user' => $user,
            ]);
        } catch (\Exception $e) {
            return response()->json([
                'status' => false,
                'message' => 'An error occurred while updating the profile',
                'error' => $e->getMessage(),
            ], 500);
        }
    }
}