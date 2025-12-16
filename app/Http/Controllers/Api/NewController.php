<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Collection;
use App\Models\Essential;
use App\Models\Store;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class NewController extends Controller
{
    public function store_list(Request $request)
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
        $data = Store::with('category', 'subcategory', 'product')->get();
        if ($data->count() > 0) {
            return response()->json([
                'status' => '1',
                'image_url' => asset('public/assets/images/store'),
                // 'video_url' => asset('public/assets/images/media'),
                'message' => 'Store List',
                'data' => $data
            ], 200);
        } else {
            return response()->json([
                'status' => '0',
                'message' => 'No Store Found'
            ], 200);
        }
    }

    public function essential_list(Request $request)
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
        $data = Essential::with('category', 'subcategory', 'product')->get();

        $data = $data->map(function ($essential) {
            return [
                'id'          => $essential->id,
                'bg_color'    => $essential->bg_color,
                'color'       => $essential->color,
                'category'    => $essential->category ? [
                    'id'        => $essential->category->id,
                    'name'      => $essential->category->name,
                    'image_url' => $essential->category->image
                        ? asset('public/assets/images/categories/' . $essential->category->image)
                        : null,
                ] : null,
                'subcategory' => $essential->subcategory ? [
                    'id'        => $essential->subcategory->id,
                    'name'      => $essential->subcategory->name,
                    'image_url' => $essential->subcategory->image
                        ? asset('public/assets/images/subcategories/' . $essential->subcategory->image)
                        : null,
                ] : null,
                'product'     => $essential->product ? [
                    'id'        => $essential->product->id,
                    'name'      => $essential->product->name,
                    'image_url' => $essential->product->image
                        ? asset('public/assets/images/product/' . $essential->product->image)
                        : null,
                ] : null,
            ];
        });
        if ($data->count() > 0) {
            return response()->json([
                'status' => '1',
                'message' => 'Essentials List',
                'data' => $data
            ], 200);
        } else {
            return response()->json([
                'status' => '0',
                'message' => 'No Essentials Found'
            ], 200);
        }
    }

    public function collection_list(Request $request)
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

        $data = Collection::with('category', 'subcategory', 'product')->get();

        $data = $data->map(function ($collection) {
            return [
                'id'          => $collection->id,
                'color'       => $collection->color,       // 👈 include color
                // 'bg_color'    => $collection->bg_color,    // 👈 include bg_color if you want
                'category'    => $collection->category ? [
                    'id'        => $collection->category->id,
                    'name'      => $collection->category->name,
                    'image_url' => $collection->category->image
                        ? asset('public/assets/images/categories/' . $collection->category->image)
                        : null,
                ] : null,
                'subcategory' => $collection->subcategory ? [
                    'id'        => $collection->subcategory->id,
                    'name'      => $collection->subcategory->name,
                    'image_url' => $collection->subcategory->image
                        ? asset('public/assets/images/subcategories/' . $collection->subcategory->image)
                        : null,
                ] : null,
                'product'     => $collection->product ? [
                    'id'        => $collection->product->id,
                    'name'      => $collection->product->name,
                    'image_url' => $collection->product->image
                        ? asset('public/assets/images/product/' . $collection->product->image)
                        : null,
                ] : null,
            ];
        });

        if ($data->count() > 0) {
            return response()->json([
                'status' => '1',
                'message' => 'Collection List',
                'data' => $data
            ], 200);
        } else {
            return response()->json([
                'status' => '0',
                'message' => 'No Collection Found'
            ], 200);
        }
    }
}
