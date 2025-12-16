<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Custum_order;
use App\Models\User;
use Illuminate\Support\Facades\Validator;

class CustomOrderController extends Controller
{
    public function list(Request $request)
    {
        $validatiion = Validator::make($request->all(), [
            'user_id' => 'required',
        ]);
        if ($validatiion->fails()) {
            return response()->json(['status' => '0',  'message' => 'Validation Error', 'error' => $validatiion->errors()->getMessages()], 400);
        } else {

            $data =
                Custum_order::where('user_id', $request->user_id)->orderBy('updated_at', 'DESC')->get();
            if (count($data) > 0) {
                return response()->json(['status' => '1', 'image_url' => asset('public/assets/images/custom'), 'message' => 'Custom Order List', 'data' => $data], 200);
            } else {
                return response()->json(['status' => '0', 'message' => 'No Order Found'], 200);
            }
        }
    }


    public function add(Request $request)
    {
        $validatiion = Validator::make($request->all(), [
            'image' => 'mimes:jpg,jpeg,png|required|max:2048',
            // 'description' => 'required|string',
            'remarks' => 'required|string',
            'user_id' => 'required',
        ]);
        if ($validatiion->fails()) {
            return response()->json(['status' => '0', 'message' => 'Validation Error', 'error' => $validatiion->errors()->getMessages()], 400);
        } else {
            $data = new Custum_order;
            $data->description = $request->description;
            $data->remarks = $request->remarks;
            $data->user_id = $request->user_id;
            if ($request->image) {
                $thumb = $request->file('image');
                $thumb_file = $this->uploadImage($thumb, '');
                $data->image = $thumb_file;
            }
            $data->save();
            $firebaseToken = User::find($request->user_id);
            // return $firebaseToken;
            if ($firebaseToken->device_token) {
                $SERVER_API_KEY = 'fhiWIucATW25FFkQEvFHRB:APA91bEvnM_8XK7UIi4HOs542fsxAA_L7OIFwOwBtVE4fXFTa_lFYrWJ-TPyYV-msfDxmUKcWdURIZjAB7uA9wcuuy9rLhE5O58d00u4ZAkF60LPqHOQb7g';

                $data = [
                    // "registration_ids" => $firebaseToken->device_token,
                    // "registration_ids" => $firebaseToken,
                    'to' => $firebaseToken->device_token,
                    "notification" => [
                        "title" => 'Custom Placed',
                        "body" => 'Custom Placed Successfully',
                    ]
                ];
                $dataString = json_encode($data);

                $headers = [
                    'Authorization: key=' . $SERVER_API_KEY,
                    'Content-Type: application/json',
                ];

                $ch = curl_init();

                curl_setopt($ch, CURLOPT_URL, 'https://fcm.googleapis.com/fcm/send');
                curl_setopt($ch, CURLOPT_POST, true);
                curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
                curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);
                curl_setopt($ch, CURLOPT_HTTPHEADER, $headers);
                curl_setopt($ch, CURLOPT_POSTFIELDS, $dataString);

                $response = curl_exec($ch);
            }
            return response()->json(['status' => '1', 'image_url' => asset('public/assets/images/custom'), 'message' => 'Custom Order Added', 'data' => $data], 200);
        }
    }


    public function uploadImage($file, $dir)
    {
        $extension = $file->getClientOriginalExtension();
        $name = str_replace(' ', '-', $file->getClientOriginalName());
        $filename =  $name;
        $file->move("public/assets/images/custom/", $filename);
        return $filename;
    }
}
