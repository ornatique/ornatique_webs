<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Category;
use App\Models\Product;
use App\Models\Store;
use App\Models\Subcategory;
use Illuminate\Http\Request;

class StoreCollection extends Controller
{
    public function index(Request $request)
    {
        $data['data'] = Store::all();
        return view('admin.store.store_list', $data);
    }


    public function add(Request $request)
    {
        if ($_POST) {
            $request->validate([
                'product_id' => 'nullable',
                'category_id' => 'nullable',
                'subcategory_id' => 'nullable',
                'image' => 'required',

            ]);
            $data =  new Store;
            if ($request->image) {
                $thumb = $request->file('image');
                $thumb_file = $this->uploadImage($thumb, '');
                $data->image = $thumb_file;
            }
            $data->product_id = $request->product_id;
            $data->category_id = $request->category_id;
            $data->subcategory_id = $request->subcategory_id;
            $data->save();
            return redirect()->route('admin_store_list')->with('msg', 'Producat Advertise Added Successfully...!!!');
        }
        $data['products'] = Product::all();
        $data['categories'] = Category::all();
        $data['subcategories'] = Subcategory::all();
        return view('admin.store.store_add', $data);
    }

    public function edit(Request $request, $id)
    {
        if ($_POST) {
            $request->validate([
                'product_id' => 'nullable',
                'category_id' => 'nullable',
                'subcategory_id' => 'nullable',
            ]);
            $data = Store::find($id);
            if ($request->image) {
                $thumb = $request->file('image');
                $thumb_file = $this->uploadImage($thumb, '');
                $data->image = $thumb_file;
            }
            $data->product_id = $request->product_id;
            $data->category_id = $request->category_id;
            $data->subcategory_id = $request->subcategory_id;
            $data->save();
            return redirect()->route('admin_store_list');
        }
        $data['data'] = Store::find($id);
        $data['products'] = Product::all();
        $data['categories'] = Category::all();
        $data['subcategories'] = Subcategory::all();
        return view('admin.store.store_edit', $data);
    }


    public function delete(request $request)
    {
        if ($_POST) {
            Store::where('id', $request->id)->delete();
            return Redirect()
                ->back()
                ->with('msg', 'Banner Deleted Successfully..!!');
        }
    }




    public function uploadImage($file, $dir)
    {
        $extension = $file->getClientOriginalExtension();

        $name = $file->getClientOriginalName();

        $filename = time() . '-' . $name;

        $file->move("public/assets/images/store/", $filename);

        return $filename;
    }
}
