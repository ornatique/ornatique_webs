<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Category;
use Illuminate\Http\Request;
use App\Models\LayoutName;
use App\Models\Layout;
use App\Models\Product;
use App\Models\Subcategory;

class LayoutNameController extends Controller
{
    public function list()
    {
        // Eager load layouts
        $data['layout_names'] = LayoutName::with('layouts')->get();
        return view('admin.layout_names.layout_name_list', $data);
    }

    public function add(Request $request)
    {
        if ($request->isMethod('post')) {
            $request->validate([
                // 'name'       => 'required|string|max:255',
                'layout_id'  => 'required|exists:layouts,id',
                'border_color' => 'nullable|string|max:20',
                'shape'      => 'nullable|string|max:50',
                'bg_color'   => 'nullable|string|max:20',
                'color'      => 'nullable|string|max:20',
            ]);

            LayoutName::create([
                // 'name'        => $request->name,
                'layout_id'   => $request->layout_id,
                'border_color' => $request->border_color,
                'shape'       => $request->shape,
                'bg_color'    => $request->bg_color,
                'color'       => $request->color,
                'category_id' => $request->category_id,
                'subcategory_id' => $request->subcategory_id,
                'product_id'      => $request->product_id,
            ]);

            return redirect('admin/layout-names/list')->with('msg', 'Layout Name Added Successfully..!!');
        }

        return view('admin.layout_names.layout_name_add', [
            'layouts' => Layout::all(),
            'categories'     => Category::all(),
            'sub_categories' => Subcategory::all(),
            'products'       => Product::all(),
        ]);
    }

    public function edit(Request $request, $id)
    {
        $layoutName = LayoutName::findOrFail($id);

        if ($request->isMethod('post')) {
            $request->validate([
                'layout_id'  => 'required|exists:layouts,id',
                'border_color' => 'nullable|string|max:20',
                'shape'      => 'nullable|string|max:50',
                'bg_color'   => 'nullable|string|max:20',
                'color'      => 'nullable|string|max:20',
            ]);

            $layoutName->update([
                'layout_id'   => $request->layout_id,
                'border_color' => $request->border_color,
                'shape'       => $request->shape,
                'bg_color'    => $request->bg_color,
                'color'       => $request->color,
                'category_id' => $request->category_id,
                'subcategory_id' => $request->subcategory_id,
                'product_id'      => $request->product_id,
            ]);

            return redirect('admin/layout-names/list')->with('msg', 'Layout Name Updated Successfully..!!');
        }

        return view('admin.layout_names.layout_name_edit', [
            'data'    => $layoutName,
            'layouts' => Layout::all(),
            'categories'     => Category::all(),
            'sub_categories' => Subcategory::all(),
            'products'       => Product::all(),
        ]);
    }

    public function delete(Request $request)
    {
        if ($request->isMethod('post')) {
            $data = LayoutName::find($request->id);
            if ($data) {
                $data->delete();
                return response()->json(['msg' => 'Layout Name Deleted Successfully..!!']);
            }
            return response()->json(['msg' => 'Layout Name Already Deleted. Reload to see..!!']);
        }
    }
}
