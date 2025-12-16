<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Essential;
use App\Models\Category;
use App\Models\Subcategory;
use App\Models\Product;
use Illuminate\Http\Request;

class EssentialController extends Controller
{
    public function list()
    {
        $data['data'] = Essential::with(['category', 'subcategory', 'product'])->get();
        return view('admin.essential.essential_list', $data);
    }

    public function add(Request $request)
    {

        // return $request;

        if ($request->isMethod('post')) {
            $request->validate([
                'category_id'     => 'nullable|exists:categories,id',
                'sub_category' => 'nullable|exists:subcategories,id',
                'product_id'      => 'nullable|exists:products,id',
                'bg_color'     => 'nullable|string|max:20',
                'color'        => 'nullable|string|max:20',
            ]);

            Essential::create([
                'category_id'    => $request->category_id,
                'subcategory_id' => $request->subcategory_id,
                'product_id'     => $request->product_id,
                'bg_color'       => $request->bg_color,
                'color'          => $request->color,
            ]);

            return redirect()
                ->route('admin_essential_list')
                ->with('msg', 'Essential Added Successfully..!!');
        }

        return view('admin.essential.essential_add', [
            'categories'     => Category::all(),
            'sub_categories' => Subcategory::all(),
            'products'       => Product::all(),
        ]);
    }

    public function edit(Request $request, $id)
    {
        $essential = Essential::findOrFail($id);

        if ($request->isMethod('post')) {
            $request->validate([
                'category'     => 'nullable|exists:categories,id',
                'sub_category' => 'nullable|exists:subcategories,id',
                'product'      => 'nullable|exists:products,id',
                'bg_color'     => 'nullable|string|max:20',
                'color'        => 'nullable|string|max:20',
            ]);

            $essential->update([
                'category_id'    => $request->category,
                'subcategory_id' => $request->sub_category,
                'product_id'     => $request->product,
                'bg_color'       => $request->bg_color,
                'color'          => $request->color,
            ]);

            return redirect()
                ->route('admin_essential_list')
                ->with('msg', 'Essential Updated Successfully..!!');
        }

        return view('admin.essential.essential_edit', [
            'data'           => $essential,
            'categories'     => Category::all(),
            'sub_categories' => Subcategory::all(),
            'products'       => Product::all(),
        ]);
    }

    public function delete(Request $request)
    {
        if ($request->isMethod('post')) {
            $data = Essential::find($request->id);
            if ($data) {
                $data->delete();
                return response()->json(['msg' => 'Essential Deleted Successfully..!!']);
            }
            return response()->json(['msg' => 'Essential Already Deleted. Reload to see..!!']);
        }
    }

    public function getSubcategories($category_id)
    {
        $subcategories = Subcategory::where('category_id', $category_id)->get();
        return response()->json($subcategories);
    }

    public function getProducts($subcategory_id)
    {
        $products = Product::where('subcategory_id', $subcategory_id)->get();
        return response()->json($products);
    }
}
