<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Permission;
use App\Models\User;
use App\Models\Category;

class PermissionController extends Controller
{
    public function list(Request $request)
    {
        $data['data'] = Permission::orderBy('created_at','DESC')->get();
        return view('admin.permission.permission_list', $data);
    }

    public function add(Request $request)
    {
        if ($_POST) {
            $request->validate([
                'category_id' => 'required',
                'user_id' => 'required',


            ]);
            $data = new Permission;
            $data->category_id = $request->category_id;
            $data->user_id = $request->user_id;
            $data->save();
            return redirect()->route('admin_permission_list')->with('msg', 'Addedd Succesfullyy..!!!');
        }

        $data['categories'] = Category::all();
        $data['users'] = User::all();
        return view('admin.permission.permission_add', $data);
    }

    public function edit(Request $request, $id)
    {
        if ($_POST) {
            $request->validate([
                'category_id' => 'required',
                'user_id' => 'required',
            ]);
            $data = Permission::find($id);
            $data->category_id = $request->category_id;
            $data->user_id = $request->user_id;

            $data->save();
            return redirect()->route('admin_permission_list')->with('msg', 'Updated Succesfullyy..!!!');
        }

        $data['categories'] = Category::all();
        $data['users'] = User::all();
        $data['data'] = Permission::find($id);
        return view('admin.permission.permission_edit', $data);
    }

    public function delete(Request $request)
    {
        if ($_POST) {
            Permission::where('id', $request->id)->delete();
            return Redirect()->back()->with('msg', 'Deleted Successfullyy...!!');
        }
    }
}