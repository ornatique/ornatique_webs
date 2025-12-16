<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Category;
use App\Models\Subcategory;
use Illuminate\Support\Facades\Validator;


class SubCategoryController extends Controller
{

    public function list(Request $request)
    {
        $subcategories = Subcategory::where('category_id', $request->category_id)->orderBy('priority', 'ASC')->get();
        if (count($subcategories) > 0) {
            return response()->json(['status' => '1', 'image_url' => asset('public/assets/images/subcategories'), 'message' => 'SubCategory List', 'data' => $subcategories], 200);
        } else {
            return response()->json(['status' => '0', 'message' => 'No Sub Category Found'], 200);
        }
    }


    public function all(Request $request)
    {
        $subcategories = Subcategory::all();
        if (count($subcategories) > 0) {
            return response()->json(['status' => '1', 'image_url' => asset('public/assets/images/subcategories'), 'message' => 'SubCategory List', 'data' => $subcategories], 200);
        } else {
            return response()->json(['status' => '0', 'message' => 'No Sub Category Found'], 200);
        }
    }


    public function add(Request $request)
    {
        $validatiion = Validator::make($request->all(), [
            'category_id' => 'required',
            'name' => 'required|string|max:255',
            'image' => 'required|max:2048|mimes:jpeg,jpg,png',
        ]);

        if ($validatiion->fails()) {
            return response()->json(['status' => '0', 'message' => 'Validation Error', 'error' => $validatiion->errors()->getMessages()], 400);
        } else {
            $data = new Subcategory;
            $data->name = $request->name;
            if ($request->image) {
                $thumb = $request->file('image');
                $thumb_file = $this->uploadImage($thumb, '');
                $data->image = $thumb_file;
            }
            $data->category_id = $request->category_id;
            $data->save();
            return response()->json(['status' => '1', 'message' => 'SubCategory Added', 'data' => $data], 200);
        }
    }

    public function delete(Request $request, $id = '')
    {
        Subcategory::where('id', $id)->delete();
        return response()->json(['status' => '1', 'message' => 'SubCategory Deleted'], 200);
    }

    public function uploadImage($file, $dir)
    {
        $extension = $file->getClientOriginalExtension();

        $name = str_replace(' ', '-', $file->getClientOriginalName());

        $filename = $name;

        $file->move("public/assets/images/subcategories/", $filename);

        return $filename;
    }
}