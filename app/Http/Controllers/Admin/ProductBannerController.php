<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Category;
use Illuminate\Http\Request;
use App\Models\Product;
use App\Models\Product_banners;
use App\Models\Subcategory;

class ProductBannerController extends Controller
{
    public function index(Request $request)
    {
        $data['data'] = Product_banners::all();
        return view('admin.product_banner.product_banner_list', $data);
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
            $data =  new Product_banners;
            if ($request->image) {
                $thumb = $request->file('image');
                $thumb_file = $this->uploadImage($thumb, '');
                $data->image = $thumb_file;
            }
            $data->product_id = $request->product_id;
            $data->category_id = $request->category_id;
            $data->subcategory_id = $request->subcategory_id;
            $data->save();
            return redirect()->route('admin_product_banners')->with('msg', 'Producat Advertise Added Successfully...!!!');
        }
        $data['products'] = Product::all();
        $data['categories'] = Category::all();
        $data['subcategories'] = Subcategory::all();
        return view('admin.product_banner.product_add', $data);
    }

    public function edit(Request $request, $id)
    {
        if ($_POST) {
            $request->validate([
                'product_id' => 'nullable',
                'category_id' => 'nullable',
                'subcategory_id' => 'nullable',
            ]);
            $data = Product_banners::find($id);
            if ($request->image) {
                $thumb = $request->file('image');
                $thumb_file = $this->uploadImage($thumb, '');
                $data->image = $thumb_file;
            }
            $data->product_id = $request->product_id;
            $data->category_id = $request->category_id;
            $data->subcategory_id = $request->subcategory_id;
            $data->save();
            return redirect()->route('admin_product_banners');
        }
        $data['data'] = Product_banners::find($id);
        $data['products'] = Product::all();
        $data['categories'] = Category::all();
        $data['subcategories'] = Subcategory::all();
        return view('admin.product_banner.product_edit', $data);
    }


    public function delete(request $request)
    {
        if ($_POST) {
            Product_banners::where('id', $request->id)->delete();
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

        $file->move("public/assets/images/banners/", $filename);

        return $filename;
    }
}
