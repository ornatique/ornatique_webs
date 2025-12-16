<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Product;
use App\Models\Banner;
use App\Models\Offer;
use App\Models\Product_banners;
use App\Models\Social;
use Illuminate\Support\Facades\Validator;


class ProductBannerController extends Controller
{
    public function list(Request $request)
    {
        $validatiion = Validator::make($request->all(), []);
        if ($validatiion->fails()) {
            return response()->json(['status' => '0',  'message' => 'Validation Error', 'error' => $validatiion->errors()->getMessages()], 400);
        } else {
            $data = Product_banners::with('product')->orderBy('updated_at', 'DESC')->get();

            if (count($data) > 0) {
                return response()->json(['status' => '1', 'image_url' => asset('public/assets/images/banners'), 'message' => 'Banner List', 'data' => $data], 200);
            } else {
                return response()->json(['status' => '0', 'message' => 'No Banners Found'], 200);
            }
        }
    }
    public function getAd(Request $request)
    {
        $data = Banner::all();
        if (count($data) > 0) {
            return response()->json(['status' => '1', 'image_url' => asset('public/assets/images/banners'), 'message' => 'Banner List', 'data' => $data], 200);
        } else {
            return response()->json(['status' => '0', 'message' => 'No Banners Found'], 200);
        }
    }

    public function offer(Request $request)
    {
        $data = Offer::all();
        if (count($data) > 0) {
            return response()->json(['status' => '1', 'message' => 'Offer List', 'data' => $data], 200);
        } else {
            return response()->json(['status' => '0', 'message' => 'No Offer Found', 'data' => $data], 200);
        }
    }

    public function social(Request $request)
    {
        $data = Social::all();
        if (count($data) > 0) {
            return response()->json(['status' => '1', 'message' => 'Social Links', 'data' => $data], 200);
        } else {
            return response()->json(['status' => '0', 'message' => 'No Data Found', 'data' => $data], 200);
        }
    }
}
