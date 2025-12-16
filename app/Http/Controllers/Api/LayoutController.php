<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Layout;
use App\Models\LayoutName;
use Illuminate\Support\Facades\Validator;

class LayoutController extends Controller
{
    /**
     * Get list of layouts
     */
    public function list()
    {
        // Load layouts with related category, subcategory, and product
        $layouts = Layout::with(['category', 'subcategory', 'product'])
            ->where('status', 1)
            ->get();

        // Transform data with full related info
        $data = $layouts->map(function ($layout) {
            return [
                'id'          => $layout->id,
                'name'        => $layout->name,
                'color'       => $layout->color,
                'border'      => $layout->border,
                'shape'       => $layout->shape,
                'image'       => $layout->image ? url('public/assets/images/layouts/' . $layout->image) : null,
                'status'      => $layout->status,
                'category'    => $layout->category ? [
                    'id' => $layout->category->id,
                    'name' => $layout->category->name,
                    'description' => $layout->category->description ?? null,
                    'created_at' => $layout->category->created_at?->format('d M Y H:i')
                ] : null,
                'subcategory' => $layout->subcategory ? [
                    'id' => $layout->subcategory->id,
                    'name' => $layout->subcategory->name,
                    'category_id' => $layout->subcategory->category_id,
                    'description' => $layout->subcategory->description ?? null,
                    'created_at' => $layout->subcategory->created_at?->format('d M Y H:i')
                ] : null,
                'product' => $layout->product ? [
                    'id' => $layout->product->id,
                    'name' => $layout->product->name,
                    'category_id' => $layout->product->category_id,
                    'subcategory_id' => $layout->product->subcategory_id,
                    'price' => $layout->product->price ?? null,
                    'sku' => $layout->product->sku ?? null,
                    'description' => $layout->product->description ?? null,
                    'created_at' => $layout->product->created_at?->format('d M Y H:i')
                ] : null,
                'created_at'  => $layout->created_at?->format('d M Y H:i'),
                'updated_at'  => $layout->updated_at?->format('d M Y H:i')
            ];
        });

        return response()->json([
            'status'  => true,
            'message' => 'Layouts fetched successfully',
            'data'    => $data
        ]);
    }


    // public function list_name(Request $request)
    // {
    //     $validator = Validator::make($request->all(), [
    //         'layout_id' => 'required|exists:layouts,id',
    //     ]);

    //     if ($validator->fails()) {
    //         return response()->json([
    //             'status'  => false,
    //             'message' => 'Validation Error',
    //             'errors'  => $validator->errors()
    //         ], 422);
    //     }

    //     $layoutNames = LayoutName::with(['layout', 'category', 'subcategory', 'product'])
    //         ->where('layout_id', $request->layout_id)
    //         ->get();

    //     $data = $layoutNames->map(function ($item) {
    //         return [
    //             'id'          => $item->id,
    //             'layout_id'   => $item->layout_id,
    //             'layout_name' => $item->layout?->name,
    //             'border_color' => $item->border_color,
    //             'shape'       => $item->shape,
    //             'bg_color'    => $item->bg_color,
    //             'color'       => $item->color,
    //             'category'    => $item->category?->name,
    //             'subcategory' => $item->subcategory?->name,
    //             'product'     => $item->product?->name,
    //             'created_at'  => $item->created_at?->format('d M Y H:i'),
    //         ];
    //     });

    //     return response()->json([
    //         'status'  => true,
    //         'message' => 'Inside App Layout  fetched successfully',
    //         'data'    => $data
    //     ]);
    // }

    public function list_name(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'layout_id' => 'required|exists:layouts,id',
        ]);

        if ($validator->fails()) {
            return response()->json([
                'status'  => false,
                'message' => 'Validation Error',
                'errors'  => $validator->errors()
            ], 422);
        }

        $layoutNames = LayoutName::with(['layout', 'category', 'subcategory', 'product'])
            ->where('layout_id', $request->layout_id)
            ->get();

        $data = $layoutNames->map(function ($item) {
            return [
                'id'            => $item->id,
                'layout_id'     => $item->layout_id,
                'layout_name'   => $item->layout?->name,
                'border_color'  => $item->border_color,
                'shape'         => $item->shape,
                'bg_color'      => $item->bg_color,
                'color'         => $item->color,

                // Category details
                'category' => [
                    'id'    => $item->category?->id,
                    'name'  => $item->category?->name,
                    'image' => $item->category?->image
                        ? asset('public/assets/images/categories/' . $item->category->image)
                        : asset('public/assets/images/categories/default.png'),
                ],

                // Subcategory details
                'subcategory' => [
                    'id'    => $item->subcategory?->id,
                    'name'  => $item->subcategory?->name,
                    'image' => $item->subcategory?->image
                        ? asset('public/assets/images/subcategories/' . $item->subcategory->image)
                        : asset('public/assets/images/subcategories/default.png'),
                ],

                // Product details
                'product' => [
                    'id'    => $item->product?->id,
                    'name'  => $item->product?->name,
                    'image' => $item->product?->image
                        ? asset('public/assets/images/product/' . $item->product->image)
                        : asset('public/assets/images/product/default.png'),
                ],

                'created_at' => $item->created_at?->format('d M Y H:i'),
            ];
        });

        return response()->json([
            'status'  => true,
            'message' => 'Inside App Layout fetched successfully',
            'data'    => $data
        ]);
    }
}