<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Like;
use App\Models\Comment;
use App\Models\Media_comment;
use App\Models\Media_like;
use Illuminate\Support\Facades\Validator;

class MediaInteractionController extends Controller
{
    // 1. Like Count API
    public function likeCount(Request $request)
    {
        $validation = Validator::make($request->all(), [
            'media_id' => 'required|integer'
        ]);

        if ($validation->fails()) {
            return response()->json(['status' => '0', 'message' => 'Validation error', 'error' => $validation->errors()], 400);
        }

        $likeCount = Media_like::where('media_id', $request->media_id)->count();

        return response()->json([
            'status' => '1',
            'media_id' => $request->media_id,
            'likes' => $likeCount
        ], 200);
    }


    // 4. Toggle Like API
    public function toggleLike(Request $request)
    {
        $validation = Validator::make($request->all(), [
            'media_id' => 'required|integer',
            'user_id' => 'required|integer',
        ]);

        if ($validation->fails()) {
            return response()->json([
                'status' => '0',
                'message' => 'Validation error',
                'error' => $validation->errors()
            ], 400);
        }

        $existingLike = Media_like::where('media_id', $request->media_id)
            ->where('user_id', $request->user_id)
            ->first();

        if ($existingLike) {
            $existingLike->delete();
            return response()->json([
                'status' => '1',
                'message' => 'Unliked successfully'
            ], 200);
        } else {
            $like = new Media_like();
            $like->media_id = $request->media_id;
            $like->user_id = $request->user_id;
            $like->save();

            return response()->json([
                'status' => '1',
                'message' => 'Liked successfully',
                'data' => $like
            ], 200);
        }
    }


    // 2. Add Comment API
    public function addComment(Request $request)
    {
        $validation = Validator::make($request->all(), [
            'media_id' => 'required|integer',
            'user_id' => 'required|integer',
            'comment' => 'required|string|max:1000'
        ]);

        if ($validation->fails()) {
            return response()->json(['status' => '0', 'message' => 'Validation error', 'error' => $validation->errors()], 400);
        }

        $comment = new Media_comment();
        $comment->media_id = $request->media_id;
        $comment->user_id = $request->user_id;
        $comment->comment = $request->comment;
        $comment->save();

        return response()->json(['status' => '1', 'message' => 'Comment added successfully', 'data' => $comment], 200);
    }

    // 3. Get Comments API
    public function listComments(Request $request)
    {
        $validation = Validator::make($request->all(), [
            'media_id' => 'required|integer'
        ]);

        if ($validation->fails()) {
            return response()->json(['status' => '0', 'message' => 'Validation error', 'error' => $validation->errors()], 400);
        }

        $comments = Media_comment::where('media_id', $request->media_id)
            ->orderBy('created_at', 'DESC')
            ->get();

        return response()->json(['status' => '1', 'media_id' => $request->media_id, 'comments' => $comments], 200);
    }
}
