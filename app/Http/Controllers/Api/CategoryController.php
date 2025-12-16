<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use App\Models\Category;
use App\Models\Permission;
use App\Models\User;
use Illuminate\Support\Facades\Auth;

class CategoryController extends Controller
{

    public function list_old(Request $request)
    {
        $validation = Validator::make($request->all(), [
            'user_id' => 'required',
        ]);
        if ($validation->fails()) {
            return response()->json(['status' => '0', 'message' => 'Validation Error', 'error' => $validation->errors()->getMessages()], 400);
        }
        $permission = User::find($request->user_id);
        // $permission = Permission::where('user_id', $request->user_id)->get('category_id')->toArray();
        // $categories = Category::where('user_id', 'like', '%' . $permission->number . '%')->orderBy('updated_at', 'DESC')->get()->makeHidden(['user_id']);
        $categories = Category::orderBy('priority', 'ASC')->get()->makeHidden(['user_id']);
        if (count($categories) > 0) {
            return response()->json(['status' => '1', 'image_url' => asset('public/assets/images/categories'), 'message' => 'Category List', 'data' => $categories], 200);
        } else {
            return response()->json(['status' => '0', 'message' => 'No Category Found'], 200);
        }
    }

    public function list(Request $request)
    {
        $request->validate([
            'user_id' => 'required|exists:users,id'
        ]);

        $user = User::find($request->user_id);

        // Decode assigned category IDs
        $categoryIds = json_decode($user->category_ids, true) ?? [];

        if (empty($categoryIds)) {
            return response()->json([
                'status' => '0',
                'message' => 'No categories assigned'
            ], 200);
        }

        $categories = Category::whereIn('id', $categoryIds)
            ->orderBy('priority', 'ASC')
            ->get();

        return response()->json([
            'status' => '1',
            'image_url' => asset('public/assets/images/categories'),
            'message' => 'Category List',
            'data' => $categories
        ], 200);
    }

    public function category_list(Request $request)
    {
        $request->validate([
            'user_id' => 'required|exists:users,id',
        ]);

        $user = User::find($request->user_id);

        $categoryIds = json_decode($user->category_ids, true) ?? [];

        if (empty($categoryIds)) {
            return response()->json([
                'status' => '0',
                'message' => 'No categories assigned',
                'data' => []
            ], 200);
        }

        $categories = Category::whereIn('id', $categoryIds)->get();

        return response()->json([
            'status' => '1',
            'data' => $categories
        ], 200);
    }



    public function category_list_old(Request $request)
    {
        $validation = Validator::make($request->all(), [
            'user_id' => 'required',
        ]);
        if ($validation->fails()) {
            return response()->json(
                [
                    'status' => '0',
                    'message' => 'Validation Error',
                    'error' => $validation->errors()->getMessages()
                ],
                400
            );
        }
        $category = Category::where('user_id', $request->user_id)->get();
        if ($category) {
            return response()->json([
                'status' => '1',
                'data' => $category,
            ], 200);
        } else {
            return response([
                'status' => '0',
                'message' => 'Validation Error',
                'error' => $validation->errors()->getMessages()
            ], 200);
        }
    }


    public function add(Request $request)
    {
        $validation = Validator::make($request->all(), [
            'name' => 'required|string|max:255',
            'image' => 'mimes:jpg,jpeg,png|required|max:2048',

        ]);
        if ($validation->fails()) {
            return response()->json(['status' => '0', 'message' => 'Validation Error', 'error' => $validation->errors()->getMessages()], 400);
        } else {
            $data = new Category;
            $data->name = $request->name;
            if ($request->image) {
                $thumb = $request->file('image');
                $thumb_file = $this->uploadImage($thumb, '');
                $data->image = $thumb_file;
            }
            $data->save();
            return response()->json([
                'status' => '0',
                'message' => 'Category added.',
                'data' => $data
            ], 200);
        }
    }

    public function edit(Request $request, $id)
    {
        $validation = Validator::make($request->all(), [
            'name' => 'required|string|max:255',
            'image' => 'mimes:jpg,jpeg,png|required|max:2048',

        ]);
        if ($validation->fails()) {
            return response()->json(['status' => '0', 'validation error' => $validation->errors()->getMessages()], 400);
        } else {
            $data =  Category::find($id);
            $data->name = $request->name;
            if ($request->image) {
                $thumb = $request->file('image');
                $thumb_file = $this->uploadImage($thumb, '');
                $data->image = $thumb_file;
            }
            $data->save();
            return response()->json(['status' => '1', 'message' => 'Category Updated.', 'data' => $data], 200);
        }
    }

    public function delete(Request $request, $id)
    {
        Category::where('id', $request->id)->delete();
        return response()->json(['status' => '1', 'message' => 'Category Deleted', 'data' => $id], 200);
    }
    public function uploadImage($file, $dir)
    {
        $extension = $file->getClientOriginalExtension();

        $name = str_replace(' ', '-', $file->getClientOriginalName());

        $filename =  $name;

        $file->move("public/assets/images/categories/", $filename);

        return $filename;
    }
}
