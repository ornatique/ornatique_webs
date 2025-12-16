<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Category;
use App\Models\Layout;
use App\Models\Product;
use App\Models\Subcategory;
use Illuminate\Http\Request;

class LayoutController extends Controller
{
    // List all layouts
    public function index()
    {
        $data['layouts'] = Layout::orderBy('created_at', 'DESC')->get();
        return view('admin.layouts.index', $data);
    }

    // Add new layout
    public function add(Request $request)
    {
        // return $request;

        if ($request->isMethod('post')) {
            $request->validate([
                'name' => 'required|string|min:2|max:255',
                'color' => 'nullable|string|max:20',
                'border' => 'nullable|string|max:50',
                'shape' => 'nullable|string|max:50',
                'image' => 'nullable|image|mimes:jpeg,png,jpg,gif,svg,png,webp|max:2048',
                'status' => 'required|in:0,1',
            ]);

            $layout = new Layout();
            $layout->fill($request->only(['name', 'color', 'border', 'shape', 'status', 'category_id', 'subcategory_id', 'product_id']));

            if ($request->hasFile('image')) {
                $layout->image = $this->uploadImage($request->file('image'));
            }
            // return $layout;
            $layout->save();

            return redirect()->route('admin_layouts.index')->with('msg', 'Layout Updated Successfully!');
        }

        return view('admin.layouts.add', [
            'categories'     => Category::all(),
            'sub_categories' => Subcategory::all(),
            'products'       => Product::all(),
        ]);
    }

    // Edit existing layout
    public function edit(Request $request, $id)
    {
        // return $request;

        $layout = Layout::findOrFail($id);

        if ($request->isMethod('post')) {
            $request->validate([
                'name' => 'required|string|min:2|max:255',
                'color' => 'nullable|string|max:20',
                'border' => 'nullable|string|max:50',
                'shape' => 'nullable|string|max:50',
                'image' => 'nullable|image|mimes:jpeg,png,jpg,gif,svg,png,webp|max:2048',
                'status' => 'required|in:0,1',
            ]);

            $layout->fill($request->only(['name', 'color', 'border', 'shape', 'status', 'category_id', 'subcategory_id', 'product_id']));

            if ($request->hasFile('image')) {
                $layout->image = $this->uploadImage($request->file('image'));
            }
            // return $layout;
            $layout->save();

            return redirect()->route('admin_layouts.index')->with('msg', 'Layout Updated Successfully!');
        }

        return view('admin.layouts.edit', [
            'layout' => $layout,
            'categories'     => Category::all(),
            'sub_categories' => Subcategory::all(),
            'products'       => Product::all(),
        ]);
    }

    // Delete layout
    public function delete(Request $request)
    {
        $layout = Layout::find($request->id);
        if ($layout) {
            $layout->delete();
            return response()->json(['msg' => 'Layout Deleted Successfully!']);
        }
        return response()->json(['msg' => 'Layout Already Deleted!']);
    }

    // Upload image helper
    private function uploadImage($file)
    {
        $name = time() . '-' . str_replace(' ', '-', $file->getClientOriginalName());
        $file->move(public_path('assets/images/layouts/'), $name);
        return $name;
    }
    public function updateStatus(Request $request)
    {
        $layout = Layout::findOrFail($request->id);
        $layout->status = $request->status;
        $layout->save();

        return response()->json(['msg' => 'Status updated successfully!']);
    }
}
