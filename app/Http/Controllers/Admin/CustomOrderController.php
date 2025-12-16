<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Custum_order;

class CustomOrderController extends Controller
{
    public function  list(Request $request)
    {
        $data['data'] = Custum_order::orderBy('created_at', 'DESC')->get();
        return view('admin.custum.custum_list', $data);
    }

    public function add(Request $request)
    {
        if ($_POST) {
            $request->validate([
                'image' => 'mimes:jpg,jpeg,png|required|max:2048',
                'description' => 'required|string|min:5',
                'remarks' => 'required|string|min:5',

            ]);
            $data = new Custum_order;
            $data->description = $request->description;
            $data->remarks = $request->remarks;
            if ($request->image) {
                $thumb = $request->file('image');
                $thumb_file = $this->uploadImage($thumb, '');
                $data->image = $thumb_file;
            }
            // return $data;
            $data->save();
            return redirect()->route('admin_custum_list')->with('msg', ' Custum Order Added Suuccesfully..!!!!');
        }
        return view('admin.custum.custum_add');
    }

    public function edit(Request $request, $id)
    {
        if ($_POST) {
            $request->validate([
                // 'image' => 'mimes:jpg,jpeg,png|required|max:2048',
                // 'description' => 'required|string|min:5',
                'remarks' => 'required|string|min:5',

            ]);
            $data =  Custum_order::find($id);
            $data->description = $request->description;
            $data->remarks = $request->remarks;
            if ($request->image) {
                $thumb = $request->file('image');
                $thumb_file = $this->uploadImage($thumb, '');
                $data->image = $thumb_file;
            }
            // return $data;
            $data->save();
            return redirect()->route('admin_custum_list')->with('msg', 'Custum Order Updated Suuccesfully..!!!!');
        }
        $data['data'] = Custum_order::find($id);
        return view('admin.custum.custum_edit', $data);
    }

    public function uploadImage($file, $dir)
    {
        $extension = $file->getClientOriginalExtension();
        $name = str_replace(' ', '-', $file->getClientOriginalName());
        $filename =  $name;
        $file->move("public/assets/images/custom/", $filename);
        return $filename;
    }

    public function delete(Request $request)
    {
        if ($_POST) {
            Custum_order::where('id', $request->id)->delete();
            return Redirect()
                ->back()
                ->with('msg', 'Custum Order Deleted Successfully..!!');
        }
    }
}
