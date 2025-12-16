<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Category;
use App\Models\Collection;
use App\Models\Product;
use App\Models\Subcategory;
use Illuminate\Http\Request;

class CollectionController extends Controller
{
    public function list()
    {
        $data['data'] = Collection::with(['category', 'subcategory', 'product'])->get();
        return view('admin.collection.list', $data);
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

            Collection::create([
                'category_id'    => $request->category_id,
                'subcategory_id' => $request->subcategory_id,
                'product_id'     => $request->product_id,
                'bg_color'       => $request->bg_color,
                'color'          => $request->color,
            ]);

            return redirect()
                ->route('admin_collection_list')
                ->with('msg', 'Collection Added Successfully..!!');
        }

        return view('admin.collection.add', [
            'categories'     => Category::all(),
            'sub_categories' => Subcategory::all(),
            'products'       => Product::all(),
        ]);
    }

    public function edit(Request $request, $id)
    {
        $essential = Collection::findOrFail($id);

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
                ->route('admin_collection_list')
                ->with('msg', 'Collection Updated Successfully..!!');
        }

        return view('admin.collection.edit', [
            'data'           => $essential,
            'categories'     => Category::all(),
            'sub_categories' => Subcategory::all(),
            'products'       => Product::all(),
        ]);
    }

    public function delete(Request $request)
    {
        if ($request->isMethod('post')) {
            $data = Collection::find($request->id);
            if ($data) {
                $data->delete();
                return response()->json(['msg' => 'Collection Deleted Successfully..!!']);
            }
            return response()->json(['msg' => 'Collection Already Deleted. Reload to see..!!']);
        }
    }
}
