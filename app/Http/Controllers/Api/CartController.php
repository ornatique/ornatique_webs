<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Cart;
use App\Models\Product;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class CartController extends Controller
{
    public function add_cart(Request $request)
    {
        $validatiion = Validator::make($request->all(), [
            'product_id' => 'required',
            'user_id' => 'required',
            'quantity' => 'required',
        ]);

        if ($validatiion->fails()) {
            return response()->json(['status' => '0', 'message' => 'Validation Error', 'error' => $validatiion->errors()->getMessages()], 400);
        } else {
            $cart = Cart::where('user_id', $request->user_id)->where('product_id', $request->product_id)->first();
            if ($cart) {
                $cart->quantity = $request->quantity;
                $cart->save();
                return
                    response()->json(['status' => '1', 'message' => 'Product Added to Cart', 'data' => $cart], 200);
            } else {
                $data = new Cart();
                $data->product_id = $request->product_id;
                $data->user_id = $request->user_id;
                $data->quantity = $request->quantity;
                $data->save();
            }
            return response()->json(['status' => '1', 'message' => 'Product Added to Cart', 'data' => $data], 200);
        }
    }


    public function edit_cart(Request $request)
    {
        $validation = Validator::make($request->all(), [
            'product_id' => 'required',
            'user_id' => 'required',
            'quantity' => 'required',
        ]);

        if ($validation->fails()) {
            return response()->json(['status' => '0', 'validation error' => $validation->errors()->getMessages()], 400);
        } else {
            $data =  Cart::where('user_id', $request->user_id)->where('product_id', $request->product_id)->first();
            if ($data) {
                $data->quantity = $request->quantity;
                $data->save();
                return response()->json(['status' => '1', 'message' => 'Quantity Updated Successfully..!!!', 'data' => $data], 200);
            } else {
                return response()->json(['status' => '0', 'message' => 'No Product Found'], 400);
            }
        }
    }

    public function view_cart(Request $request)
    {
        $validatiion = Validator::make($request->all(), [
            'user_id' => 'required',
        ]);

        if ($validatiion->fails()) {
            return response()->json(['status' => '0', 'message' => 'Validation Error', 'error' => $validatiion->errors()->getMessages()], 400);
        } else {
            $data = Cart::where('user_id', $request->user_id)->with('product')->get(); //orderBy('updated_at', 'DESC')
            if (count($data) > 0) {
                return response()->json(['status' => '1', 'message' => 'Cart List', 'image_url' => asset('public/assets/images/product'), 'data' => $data], 200);
            } else {
                return response()->json(['status' => '0', 'message' => 'Empty Cart'], 400);
            }
        }
    }

    public function delete_cart(Request $request)
    {
        $validatiion = Validator::make($request->all(), [
            'user_id' => 'required',
            'product_id' => 'required',
        ]);

        if ($validatiion->fails()) {
            return response()->json(['status' => '0', 'message' => 'Validation Error', 'error' => $validatiion->errors()->getMessages()], 400);
        } else {
            Cart::where('user_id', $request->user_id)
                ->where('product_id', $request->product_id)
                ->delete();
            return response()->json(['status' => '1', 'message' => 'Product Removed From Cart'], 200);
        }
    }
}
