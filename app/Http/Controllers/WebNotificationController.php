<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\User;
use App\Models\Notification;

class WebNotificationController extends Controller
{
    // public function __construct()
    // {
    //     $this->middleware('auth');
    // }
    public function index(Request $request)
    {
        return view('ind');
    }

    public function list(Request $request)
    {
        $data['data'] = Notification::orderBy('created_at', 'DESC')->get();;
        return view('admin.notification.notification_list', $data);
    }

    // public function storeToken(Request $request)
    // {
    //     // auth()->user()->update(['device_key' => $request->token]);
    //     // return $request;
    //     return response()->json(['Token successfully stored.']);
    // }

    // public function sendWebNotification(Request $request)
    // {
    //     $url = 'https://fcm.googleapis.com/fcm/send';
    //     // $url = "https://fcm.googleapis.com/v1/projects/golden-beads/messages:send";
    //     $FcmToken = User::whereNotNull('device_key')->pluck('device_key')->all();

    //     $serverKey = 'AAAArsRB_ow:APA91bF-4QXz5uEhU1QkNWWYi9-UPAuNJgzpDa6saeWPk-Q86keKWq1aO_k0FOqUJCQt861kA9efNZ7IxiAECWbzziwMFUlMjWjFyTfFORZEwRVk1MYsg8RI_tkXQypEGuLDwoshfyGX';

    //     $data = [
    //         "to" => 'dSaQVT36REGuia5p4T0Ia6:APA91bHt_2xDFj3TBlUSuQZLwB-L4hhFjGYsmSi2T6FBmwKs4DWSVmmftRcP-8Kj4ZErGOjaMwV7hUUbnVAYFEFqpnQq1CDNcw9yVsxJeB204JQchzDerjf4sMQmlEp1NyFd1af-aknu',
    //         // "register_id" => 'BJcMs75is54bZGv7KKxaYSKLAiu-_ek2y2WscoLYbUfstglkkSbnkXURSCHkDSL-Xm8Vaz-G-EGAepgmiMCtmaM',
    //         "notification" => [
    //             "title" => $request->title,
    //             "body" => $request->body,
    //         ]
    //     ];
    //     $encodedData = json_encode($data);

    //     $headers = [
    //         'Authorization:key=' . $serverKey,
    //         'Content-Type: application/json',
    //     ];

    //     $ch = curl_init();

    //     curl_setopt($ch, CURLOPT_URL, $url);
    //     curl_setopt($ch, CURLOPT_POST, true);
    //     curl_setopt($ch, CURLOPT_HTTPHEADER, $headers);
    //     curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
    //     curl_setopt($ch, CURLOPT_SSL_VERIFYHOST, 0);
    //     curl_setopt($ch, CURLOPT_HTTP_VERSION, CURL_HTTP_VERSION_1_1);
    //     // Disabling SSL Certificate support temporarly
    //     curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);
    //     curl_setopt($ch, CURLOPT_POSTFIELDS, $encodedData);
    //     // Execute post
    //     $result = curl_exec($ch);
    //     if ($result === FALSE) {
    //         die('Curl failed: ' . curl_error($ch));
    //     }
    //     // Close connection
    //     curl_close($ch);
    //     // FCM response
    //     dd($result);
    // }


    public function delete(Request $request)
    {
        // Validate incoming request
        $request->validate([
            'id' => 'required|integer|exists:notifications,id',
        ]);

        // Find the notification
        $notification = Notification::find($request->id);

        if ($notification) {
            // ✅ Actually delete it
            $notification->delete();

            return response()->json([
                'status' => 'success',
                'msg' => 'Notification deleted successfully.',
            ]);
        }

        return response()->json([
            'status' => 'error',
            'msg' => 'Notification not found.',
        ], 404);
    }
}