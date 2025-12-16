<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Category;
use App\Models\Subcategory;
use App\Models\Product;
use App\Models\Wishlist;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class ProductController extends Controller
{

    public function list(Request $request)
    {
        $validatiion = validator::make($request->all(), [
            'user_id' => 'required',
        ]);
        if ($validatiion->fails()) {
            return response()->json(['status' => '0', 'message' => 'Validation Error', 'error' => $validatiion->errors()->getMessages()], 400);
        }

        $products = DB::table('products');

        if ($request->category_id) {
            $products->where('category_id', $request->category_id);
        }
        if ($request->subcategory_id) {
            $products->where('subcategory_id', $request->subcategory_id);
        }
        $products->leftJoin('wishlists', function ($join) use ($request) {
            $join->on('products.id', '=', 'wishlists.product_id')
                ->where('wishlists.user_id', $request->user_id);
        })
            ->select('products.*', DB::raw("ifnull(is_key, 0) as is_key"));
        // $products = $products->orderBy('id', 'DESC')->orderBy('created_at', 'DESC')->get();
        //$products = $products->orderByRaw('CAST(name AS INTEGER) DESC')->orderBy('created_at', 'DESC')->get();
        $products = $products
        ->orderByRaw('CAST(name AS SIGNED) DESC')
        ->orderBy('created_at', 'DESC')
        ->get();

        if (count($products) > 0) {
            return response()->json(['status' => '1', 'image_url' => asset('public/assets/images/product'), 'message' => 'Product List', 'data' => $products], 200);
        } else {
            return response()->json(['status' => '0', 'message' => 'No Product Found'], 200);
        }
    }

    public function details(Request $request)
    {
        $validatiion = validator::make($request->all(), [
            'product_id' => 'required',
        ]);

        if ($validatiion->fails()) {
            return response()->json(['status' => '0', 'message' => 'Validation Error', 'error' => $validatiion->errors()->getMessages()], 400);
        } else {
            $data = Product::where('products.id', $request->product_id)->leftJoin('wishlists', function ($join) use ($request) {
                $join->on('products.id', '=', 'wishlists.product_id')
                    ->where('wishlists.user_id', $request->user_id);
            })
                ->select('products.*', DB::raw("ifnull(is_key,0)as is_key"), DB::raw("ifnull(number,0)as number"))->first();

            // if ($data) {
            //     $data
            if ($data) {
                return response()->json([
                    'status' => '1',
                    'message' => 'Product Detail',
                    'image_url' => asset('public/assets/images/product'),
                    'data' => $data,
                ], 200);
            } else {
                return response()->json([
                    'status' => '0',
                    'message' => 'No Product Found',
                ], 401);
            }
        }
        // }
    }






    public function add(Request $request)
    {
        $validatiion = validator::make($request->all(), [
            'name' => 'required|string|max:255',
            'category_id' => 'required',
            'quantity' => 'required',
            'subcategory_id' => 'required',
            'weight' => 'required',
            'number' => 'required',
            'size' => 'required',
            'hole_size' => 'required',
            'image' => 'mimes:jpg,jpeg,png|required|max:2048',
        ]);

        if ($validatiion->fails()) {
            return response()->json(['status' => '0', 'message' => 'Validation Error', 'error' => $validatiion->errors()->getMessages()], 400);
        } else {
            $data = new Product;
            $data->name = $request->name;
            $data->category_id = $request->category_id;
            $data->subcategory_id = $request->subcategory_id;
            $data->weight = $request->weight;
            $data->number = $request->number;
            $data->quantity = $request->quantity;
            $data->size = $request->size;
            $data->hole_size = $request->hole_size;
            if ($request->image) {
                $thumb = $request->file('image');
                $thumb_file = $this->uploadImage($thumb, '');
                $data->image = $thumb_file;
            }
            $data->save();
            if ($data) {
                $data->delete();
                return response()->json(['status' => '1', 'message' => 'Product Added To favourite', 'data' => $data], 200);
            } else {
                return response()->json(['status' => '0', 'message' => 'Remove From Wishlist', 'data' => $data], 400);
            }
        }
    }


    public function uploadImage($file, $dir)
    {
        $extension = $file->getClientOriginalExtension();

        $name = str_replace(' ', '-', $file->getClientOriginalName());

        $filename = str_replace(' ', '-', $file->getClientOriginalName());

        $file->move("public/assets/images/product/", $filename);

        return $filename;
    }

    public function wishlist(Request $request)
    {
        $validatiion = validator::make(
            $request->all(),
            [
                'product_id' => 'required',
                'user_id' => 'required',
                'is_key' => 'required',
            ]
        );
        if ($validatiion->fails()) {
            return response()->json(['status' => '0', 'message' => 'Validation Error', 'error' => $validatiion->errors()->getMessages()], 400);
        } else if ($request->is_key == 1) {

            $data = Wishlist::where('user_id', $request->user_id)->where('product_id', $request->product_id)->first();
            if ($data) {
                return response()->json(['status' => '1', 'message' => 'Product already in Wishlist', 'data' => $data], 200);
            }
            $data = new Wishlist;
            $data->user_id = $request->user_id;
            $data->product_id = $request->product_id;
            $data->is_key = $request->is_key;
            $data->save();
            return response()->json(['status' => '1', 'message' => 'Product Added to Wishlist', 'data' => $data], 200);
        } else {
            $data = Wishlist::where('user_id', $request->user_id)->where('product_id', $request->product_id)->first();
            if ($data) {
                $data->delete();
                return response()->json(['status' => '1', 'message' => 'Product Remove from Wishlist', 'data' => $data], 200);
            } else {
                return response()->json(['status' => '0', 'message' => 'Product not found in Wishlist', 'data' => $data], 400);
            }
        }
    }


    public function remove_wishlist(Request $request)
    {
        $validatiion = validator::make(
            $request->all(),
            [
                'product_id' => 'required',
                'user_id' => 'required',
                'is_key' => 'required',
            ]
        );
        if ($validatiion->fails()) {
            return response()->json(['status' => '0', 'message' => 'Validation Error', 'error' => $validatiion->errors()->getMessages()], 400);
        } else {
            $data = Wishlist::where('user_id', $request->user_id)->where('product_id', $request->product_id)->first();
            if ($data) {
                $data->delete();
                return response()->json(['status' => '1', 'message' => 'Product Remove from Wishlist', 'data' => $data], 200);
            } else {
                return response()->json(['status' => '0', 'message' => 'Product not found in Wishlist', 'data' => $data], 400);
            }
        }
    }


    public function getlist(Request $request)
    {
        $data = Wishlist::with('product')->where('user_id', $request->user_id)->get();
        if (count($data) > 0) {
            return response()->json(['status' => '1', 'image_url' => asset('public/assets/images/product'),  'message' => 'Wishlist List', 'data' => $data], 200);
        } else {
            return response()->json(['status' => '0', 'message' => 'Not Product in Wishlist'], 200);
        }
    }
}