<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Product;
use App\Models\Save;
use App\Models\Cart;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Validator;

class SaveController extends Controller
{
    public function index(Request $request)
    {
        $validatiion = validator::make(
            $request->all(),
            [
                'user_id' => 'required',
                'product_id' => 'required',
            ]
        );
        if ($validatiion->fails()) {
            return response()->json([
                'status' => '0',
                'message' => 'Validation Error',
                'error' => $validatiion->errors()->getMessages()
            ], 400);
        }
        $data = Save::where('user_id', $request->user_id)->where('product_id', $request->product_id)->first();
        if (!$data) {
            $data = new Save();
            $data->user_id = $request->user_id;
            $data->product_id = $request->product_id;
            $data->is_save = $request->is_save;
            $data->save();
        }
        $save = Save::select('products.id', 'products.gallery', 'products.name', 'products.size', 'products.weight', 'products.gross_weight', 'products.less_weight')->where('user_id', $request->user_id)->join('products', function ($join) {
            $join->on('saves.product_id', '=', 'products.id');
        })->orderBy('saves.created_at', 'DESC')->addSelect(DB::raw("'1' as quantity"))->get();
        if (count($save) > 0) {
            return response()->json(
                [
                    'status' => '1',
                    'image_url' => asset('public/assets/images/product'),
                    'message' => 'QR Save List',
                    'data' => $save
                ],
                200
            );
        } else {
            return response()->json([
                'status' => '0',
                'message' => 'Not Product in Save List'
            ], 200);
        }
    }


    public function index_new(Request $request)
    {
        $validation = validator::make(
            $request->all(),
            [
                'user_id' => 'required',
            ]
        );

        if ($validation->fails()) {
            return response()->json([
                'status' => '0',
                'message' => 'Validation Error',
                'error' => $validation->errors()->getMessages()
            ], 400);
        }

        // Fetch save records with related product details
        $data = Save::with('product')
            ->where('user_id', $request->user_id)
            ->where('is_save', '1')
            ->get();

        if ($data->count() > 0) {
            return response()->json([
                'status' => '1',
                'image_url' => asset('public/assets/images/product'),
                'message' => 'QR Save List',
                'data' => $data
            ], 200);
        } else {
            return response()->json([
                'status' => '0',
                'message' => 'No Product in Save List'
            ], 200);
        }
    }



    public function add(Request $request)
    {
        $validatiion = validator::make(
            $request->all(),
            [
                'product_id' => 'required',
                'user_id' => 'required',
                'is_save' => 'required'
            ]
        );
        if ($validatiion->fails()) {
            return response()->json([
                'status' => '0',
                'message' => 'Validation Error',
                'error' => $validatiion->errors()->getMessages()
            ], 400);
        } elseif ($request->is_save == 1) {
            $data = Save::where('user_id', $request->user_id)->where('product_id', $request->product_id)->first();
            if ($data) {
                return response()->json([
                    'status' => '1',
                    'message' => 'Product already in Save List',
                    'data' => $data
                ], 200);
            }
            $data = new Save();
            $data->user_id = $request->user_id;
            $data->product_id = $request->product_id;
            $data->is_save = $request->is_save;
            $data->save();
            return response()->json([
                'status' => '1',
                'message' => 'Product Added to Save List',
                'data' => $data
            ], 200);
        }
    }


    public function add_new(Request $request)
    {
        $validation = validator::make(
            $request->all(),
            [
                'product_id' => 'required',
                'user_id' => 'required',
                'is_save' => 'required'
            ]
        );

        if ($validation->fails()) {
            return response()->json([
                'status' => '0',
                'message' => 'Validation Error',
                'error' => $validation->errors()->getMessages()
            ], 400);
        }

        if ($request->is_save == 1) {
            $existing = Save::with('product')
                ->where('user_id', $request->user_id)
                ->where('product_id', $request->product_id)
                ->first();

            if ($existing) {
                return response()->json([
                    'status' => '1',
                    'message' => 'Product already in Save List',
                    'data' => $existing
                ], 200);
            }

            $data = new Save();
            $data->user_id = $request->user_id;
            $data->product_id = $request->product_id;
            $data->is_save = $request->is_save;
            $data->save();
            // save the data in cart 

            $cart = Cart::where('user_id', $request->user_id)
            ->where('product_id', $request->product_id)
            ->first();

            if (!$cart) {
            Cart::create([
                'user_id'   => $request->user_id,
                'product_id' => $request->product_id,
                'quantity'  => $request->quantity ?? 1,
                ]);
            }

            // Load product relation
            $data->load('product');

            return response()->json([
                'status' => '1',
                'message' => 'Product Added to Save List',
                'data' => $data
            ], 200);
        }

        return response()->json([
            'status' => '0',
            'message' => 'Invalid is_save value'
        ], 400);
    }



    public function delete(Request $request)
    {
        $validatiion = validator::make(
            $request->all(),
            [
                'user_id' => 'required',
            ]
        );
        if ($validatiion->fails()) {
            return response()->json([
                'status' => '0',
                'message' => 'Validation Error',
                'error' => $validatiion->errors()->getMessages()
            ], 400);
        }

        $data = Save::where('user_id', $request->user_id)->delete();
        return response()->json([
            'status' => '1',
            'message' => 'Products Deleted',
            // 'Data' => $user,
        ], 201);
    }
}
