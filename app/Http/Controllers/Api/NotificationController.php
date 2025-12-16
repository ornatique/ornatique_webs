<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Link;
use Illuminate\Http\Request;
use App\Models\Notification;
use Illuminate\Support\Facades\Validator;
use App\Models\User;
use App\Models\Privacy;
use Illuminate\Foundation\Auth\User as AuthUser;

use Illuminate\Support\Carbon;


class NotificationController extends Controller
{
    public function list(Request $request)
    {
        $validation = validator::make($request->all(), [
            'user_id' => 'required',
        ]);
        if ($validation->fails()) {
            return response(['status' => '0', 'message' => 'Validation Error', 'error' => $validation->errors()->getMessages()], 200);
        }
        Notification::where('user_id', $request->user_id)->where('created_at', '<=', Carbon::now()->subDay())->delete();
        $data = Notification::where('user_id', $request->user_id)->with('user')->with('product')->orderBy('updated_at', 'DESC')->get();
        // $data = Notification::with('user')->get();

        if (count($data) > 0) {
            return response()->json(['status' => '1',  'message' => 'Notification List', 'data' => $data], 200);
        } else {
            return response()->json(['status' => '0', 'message' => 'Notification Not Found'], 200);
        }
    }

    public function links(Request $request)
    {
        $data = Link::all();
        if (count($data) > 0) {
            return response()->json(['status' => '1', 'image_url' => asset('public/assets/images/links'), 'message' => 'Link List', 'data' => $data], 200);
        } else {
            return response()->json(['status' => '0', 'message' => 'Links Not Found'], 200);
        }
    }
    public function privacy()
    {
        $data = Privacy::first();
        $data->makeHidden(['terms']);

        return response()->json(['status' => '1',  'message' => 'Privacy Policy', 'data' => $data], 200);
    }

    public function terms()
    {
        $data = Privacy::first();
        $data->makeHidden(['privacy']);

        return response()->json(['status' => '1',  'message' => 'Privacy Policy', 'data' => $data], 200);
    }

    public function delete(Request $request)
    {
        $validation = validator::make($request->all(), [
            'user_id' => 'required',
        ]);
        if ($validation->fails()) {
            return response(['status' => '0', 'message' => 'Validation Error', 'error' => $validation->errors()->getMessages()], 200);
        }
        User::where('id', $request->user_id)->delete();
        return response()->json(['status' => '1',  'message' => 'User Deleted'], 200);
    }
    public function sizer(Request $request)
    {
        $validation = validator::make($request->all(), [
            'name' => 'required',
        ]);
        if ($validation->fails()) {
            return response(['status' => '0', 'message' => 'Validation Error', 'error' => $validation->errors()->getMessages()], 400);
        }
        $image = asset('public/assets/images/bead_sizer') . '/' . $request->name . '.png';
        return response(['status' => '1', 'message' => 'Bead Sizer Image', 'image_url' => $image], 200);
    }
}