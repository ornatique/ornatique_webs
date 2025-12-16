<?php

namespace App\Http\Controllers;

use App\Models\Feedback;
use Illuminate\Http\Request;

class FeedbackController extends Controller
{
    public function index(request $request)
    {
        if ($_POST) {
            $request->validate([
                'subject' => 'required|string|min:2|max:255',
                'message' => 'required|string|min:3',
            ]);
            if (isset($request->active) && $request->active == 'on') {
                $active = '1';
            } else {
                $active = '0';
            }
            $data = new Feedback;
            $data->subject = $request->subject;
            $data->message = $request->message;
            $data->user_id = 1;
            if ($request->active) {
                $data->status = $request->active;
            }
            // return $data;
            $data->save();
        }
        return view('frontend.feedback');
    }
}
