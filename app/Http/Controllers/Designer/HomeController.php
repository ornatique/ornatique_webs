<?php

namespace App\Http\Controllers\Designer;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Assets;
use App\Models\Blog;
use App\Models\Creator;
use App\Models\Desinger_faq;
use App\Models\Faq;
use App\Models\Follower;
use App\Models\Like;
use Illuminate\Support\Facades\Auth;

class HomeController extends Controller
{
    public function home()
    {
        $data['assets'] = Assets::all();
        $data['headers'] = Faq::all();
        $data['blogs'] = Blog::all();
        return view('designer.designer-home', $data);
    }

    public function faq()
    {
        $data['headers'] = Faq::all();
        return view('designer.designer-faq', $data);
    }

    public function assetsDetail(Request $request, $id)
    {
        $data['data'] = Assets::where('id', $id)->first();
        return view('designer.assets-detail', $data);
    }

    public function creatorCommunity()
    {
        $data['faqs'] = Desinger_faq::all();
        return view('designer.creator-community', $data);
    }

    public function follow(Request $request)
    {
        $data = new Follower();
        $data->creator_id = $request->creator_id;
        if (Auth::check()) {
            $data->user_id = Auth::id();
        } else {
            $data->user_id = $request->ip();
        }
        // return $data;
        $data->save();
    }

    public function unfollow(Request $request)
    {
        Follower::where('creator_id', $request->creator_id)->delete();
    }

    public function getlikes(Request $request)
    {
        $data = new Like();
        $data->asset_id = $request->asset_id;
        $data->user_id = $request->user_id;
        // return $data;
        $data->save();
    }

    public function unlike(Request $request)
    {
        Like::where('asset_id', $request->asset_id)->delete();
    }
}
