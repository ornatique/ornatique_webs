<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Media;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class MediaController extends Controller
{
    public function list(Request $request)
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

        $media = Media::orderBy('created_at', 'DESC')->get();

        if ($media->count() > 0) {
            return response()->json([
                'status' => '1',
                'image_url' => asset('public/assets/images/media'),
                'video_url' => asset('public/assets/images/media'),
                'message' => 'Media List',
                'data' => $media
            ], 200);
        } else {
            return response()->json([
                'status' => '0',
                'message' => 'No Media Found'
            ], 200);
        }
    }



    public function filter(Request $request)
    {
        // Both fields are required
        $validation = Validator::make($request->all(), [
            'category_id' => 'required|integer|exists:categories,id',
            'subcategory_id' => 'required|integer|exists:subcategories,id',
        ]);

        if ($validation->fails()) {
            return response()->json([
                'status' => '0',
                'message' => 'Validation Error',
                'error' => $validation->errors()->getMessages()
            ], 400);
        }

        // Fetch media where BOTH match
        $media = Media::where('category_id', $request->category_id)
            ->where('subcategory_id', $request->subcategory_id)
            ->orderBy('created_at', 'DESC')
            ->get();

        if ($media->count() > 0) {
            return response()->json([
                'status' => '1',
                'image_url' => asset('public/assets/images/media'),
                'video_url' => asset('public/assets/images/media'),
                'message' => 'Filtered Media List',
                'data' => $media
            ], 200);
        } else {
            return response()->json([
                'status' => '0',
                'message' => 'No Media Found for given category & subcategory'
            ], 200);
        }
    }
}