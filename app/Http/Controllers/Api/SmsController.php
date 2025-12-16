<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Twilio\Rest\Client;

class SmsController extends Controller
{

    public function sendTestOtp(Request $request)
    {
        $request->validate([
            'to' => 'required|string',
        ]);

        try {
            $otp = rand(1000, 9999); // generate random 4-digit OTP

            $sid = env('TWILIO_SID');
            $token = env('TWILIO_AUTH_TOKEN');
            $from = env('TWILIO_PHONE');
            $client = new Client($sid, $token);

            $message = "Your verification OTP is: $otp";

            $client->messages->create($request->to, [
                'from' => $from,
                'body' => $message,
            ]);

            return response()->json([
                'success' => true,
                'message' => 'Test OTP sent successfully!',
                'otp' => $otp // show OTP in response for testing only
            ]);
        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'error' => $e->getMessage()
            ], 500);
        }
    }
}
