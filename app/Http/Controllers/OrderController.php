<?php

namespace App\Http\Controllers;

use App\Models\Order;
use App\Models\Cart;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Auth;

class OrderController extends Controller
{
    public function index(request $request)
    {
        $data['data'] = Order::select('*')->where('user_id', Auth::id())->groupBy('order_id')->with('avgReview_product')->with('avgReview_asset')->with('user')->get();
        $data['items'] = Order::select(DB::raw('count(*) as total'))->groupBy('order_id')->get()->toArray();
        return view('frontend.track.track_list', $data);
    }

    public function detail(request $request, $name)
    {
        $data['data'] = Order::where('order_id', $name)
            ->first();
        return view('frontend.track.track_detail', $data);
    }

    public function order(request $request)
    {
        // return $request;
        $order_id = $request->order_id;
        for ($i = 0; $i < count($request->asset_id); $i++) {
            if ($_POST) {
                $data = new Order;
                $data->order_group_id = $order_id;
                $data->order_id = $order_id . $i;
                $data->user_id = '1';
                if ($request->product_id[$i] != '-') {
                    $data->product_id = $request->product_id[$i];
                } else {
                    $data->product_id = '';
                }
                if ($request->category_id[$i] != '-') {
                    $data->category_id = $request->category_id[$i];
                } else {
                    $data->category_id = '';
                }
                $data->product_name = $request->product_name[$i];
                if ($request->asset_id[$i] != '-') {
                    $data->asset_id = $request->asset_id[$i];
                } else {
                    $data->asset_id = '';
                }
                $data->quantity = $request->quantity[$i];
                $data->sub_total = $request->total[$i];
                $data->cart_total = $request->grand_total;
                $data->sale_price = $request->sale_price[$i];
                // $data->discount = $request->discount[$i];
                $data->image = $request->image[$i];
                $data->size = $request->size[$i];
                // return $data;
                // print_r($data);
                $data->save();
                $cart = Cart::query();
                if (Auth::check()) {
                    $cart->where('user_id', Auth::id());
                } else {
                    $cart->where('user_id', $request->ip());
                }
                $cart->delete();
            }
        }
        // return;
        return redirect()->route('track_order_list');
    }
}