<?php

namespace App\Http\Controllers;

use App\Models\Assets;
use App\Models\Product;
use App\Models\Product_detail;
use Illuminate\Http\Request;
use App\Models\Ratings;

class RatingController extends Controller
{
    public function index(Request $request)
    {
        $data['data'] = Ratings::all();
        return view('admin.review.review_list', $data);
    }
    public function delete(request $request)
    {
        if ($_POST) {
            Ratings::where('id', $request->id)->delete();
            return Redirect()->back()->with('msg', 'Review Deleted Successfully..!!');
        }
        return Redirect()->back();
    }

    public function review(Request $request)
    {
        $data = new Ratings;
        if ($request->product_id) {
            $data->product_id = $request->product_id;
        }
        if ($request->asset_id) {
            $data->asset_id = $request->asset_id;
        }
        $data->name = $request->name;
        $data->email = $request->email;
        $data->message = $request->message;
        $data->rating = $request->rating2;
        // return $data;
        $data->save();

        if ($request->product_id) {
            $rating = Product::find($request->product_id);
            Product_detail::where('product_id', $request->product_id)->update(['ratings' => $rating->avg_review]);
            return $rating->avg_review;
        }
        if ($request->asset_id) {
            $rating = Assets::find($request->asset_id);
            $rating->ratings =  $rating->avg_review;
            $rating->save();
            return $rating;
        }
    }
}