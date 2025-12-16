<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Heading;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class HeadingController extends Controller
{
    public function heading_list(Request $request)
    {
        $validation = Validator::make($request->all(), [
            'user_id' => 'required' // if needed, otherwise remove this
        ]);

        if ($validation->fails()) {
            return response()->json([
                'status' => '0',
                'message' => 'Validation Error',
                'error' => $validation->errors()->getMessages()
            ], 400);
        }
        $data = Heading::first();
        if ($data->count() > 0) {
            return response()->json([
                'status' => '1',
                // 'image_url' => asset('public/assets/images/store'),
                // 'video_url' => asset('public/assets/images/media'),
                'message' => 'Heading List',
                'data' => $data
            ], 200);
        } else {
            return response()->json([
                'status' => '0',
                'message' => 'No Heading Found'
            ], 200);
        }
    }
}
