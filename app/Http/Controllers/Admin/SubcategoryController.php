<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Category;
use App\Models\Product;
use App\Models\Subcategory;
use Illuminate\Http\Request;

class SubcategoryController extends Controller
{
    public function index()
    {
        // Eager load product count for each subcategory
        $data['subcategories'] = Subcategory::withCount('products')
            ->orderByRaw('-priority DESC')
            ->get();

        return view('admin.subcategory.subcategory_list', $data);
    }


    public function add(request $request)
    {
        if ($_POST) {
            $request->validate([
                'name' => 'required|string|min:2|max:255',
                'category_id' => 'required',
                'image' => 'required|image|mimes:jpeg,png,jpg,gif,svg|max:2048',
                'priority' => 'required'
            ]);
            $data = new Subcategory;
            $data->priority = $request->priority;
            $data->name = $request->name;
            $data->color = $request->color;
            // $data->quantity = $request->quantity;
            $data->category_id = $request->category_id;
            if ($request->image) {
                $thumb = $request->file('image');
                $thumb_file = $this->uploadImage($thumb, '');
                $data->image = $thumb_file;
            }
            $data->save();
            return redirect()->route('admin_subcategory_list')->with('msg', 'Subcategory Added Successfully..!!');
        }
        $data['categories'] = Category::all();
        return view('admin.subcategory.subcategory_add', $data);
    }

    public function uploadImage($file, $dir)
    {
        $extension = $file->getClientOriginalExtension();
        $name = str_replace(' ', '-', $file->getClientOriginalName());
        $filename =  $name;
        $file->move("public/assets/images/subcategories/", $filename);
        return $filename;
    }

    public function edit(request $request, $id)
    {
        if ($_POST) {
            $request->validate([
                'name' => 'required|string|min:2|max:255',
                'category_id' => 'required',
                'image' => 'image|mimes:jpeg,png,jpg,gif,svg|max:2048',
                'priority' => 'required'
            ]);
            $data = Subcategory::find($id);
            $data->priority = $request->priority;
            $data->color = $request->color;
            $data->name = $request->name;
            // $data->quantity = $request->quantity;
            $data->category_id = $request->category_id;
            if ($request->image) {
                $thumb = $request->file('image');
                $thumb_file = $this->uploadImage($thumb, '');
                $data->image = $thumb_file;
            }
            $data->save();



            // Sync products
            Product::where('subcategory_id', $id)
                ->update(['category_id' => $data->category_id]);


            return redirect()->route('admin_subcategory_list')->with('msg', 'Subcategory Edited Successfully..!!');
        }
        $data['data'] = Subcategory::find($id);
        $data['categories'] = Category::all();
        return view('admin.subcategory.subcategory_edit', $data);
    }

    public function delete(request $request)
    {
        if ($_POST) {
            $data = Subcategory::find($request->id);
            if ($data) {
                $data->delete();
                return response()->json(['msg' => 'Subcategory Deleted Successfully..!!']);
            } else {
                return response()->json(['msg' => 'Subcategory Already Deleted. Reload to see..!!']);
            }
            Subcategory::where('id', $request->id)->delete();
            return Redirect()->back()->with('msg', 'Subcategory Deleted Successfully..!!');
        }
        return Redirect()->back();
    }
    public function get_sub(Request $request)
    {
        $data = Subcategory::where('category_id', $request->id)->get();
        $html = '<option value="" selected="" hidden>Select Sub Category</option>';
        foreach ($data as $sub) {
            $html .= '<option value="' . $sub->id . '" >' . ucwords($sub->name) . '</option>';
        }
        return $html;
    }
}