<?php

namespace App\Http\Controllers;

use App\Models\Assets;
use App\Models\Category;
use App\Models\Product;
use App\Models\Product_detail;
use App\Models\Creator;
use App\Models\Color;
use App\Models\Ratings;
use App\Models\Size;
use App\Models\Sizeguide;
use App\Models\Notify;
use Facade\FlareClient\Http\Response;
use Illuminate\Http\Request;
use Illuminate\Pagination\LengthAwarePaginator;
use Symfony\Component\HttpFoundation\Session\Session;

class ProductController extends Controller
{


    public function __construct()
    {
        //
    }


    public function index(Request $request, $id = '')
    {
        if (!$request->filter) {
            if ($request->category) {
                $data['cat_id'] = $request->category;
            } else {
                $data['cat_id'] = $id;
            }
            $data['category_name'] = Category::find($data['cat_id']);
            if (!$request->session()->get('category_name')) {
                $request->session()->put('category_name', $data['category_name']);
            }
            $product = Product::query();
            if ($data['cat_id']) {
                $product->where('category_id', $data['cat_id']);
            }
            if ($request->sub_category) {
                $product->where('subCategory_id', $request->sub_category);
                $data['sub_id'] = $request->sub_category;
            }
            $data['products'] = $product->where('active', '1')->paginate(3);
        } else {
            // if ($paginator->getCurrentPage()) {
            //     return 'hi';
            // }
            $data['filters'] = $request->all();
            $details = Product_detail::query();
            $details->groupBy('product_id');
            if ($request->category_id) {
                $details->whereIn('category_id', $request->category_id);
            }
            if ($request->creator) {
                $details->whereIn('creator_id', $request->creator);
            }
            if ($request->discount) {
                $details->where('discount', '>=', min($request->discount));
            }
            if ($request->size) {
                $details->orWhereIn('size', $request->size);
            }
            if ($request->color) {
                $details->orWhereIn('color', $request->color);
            }
            if ($request->sort_by) {
                $request->session()->put('sort_by', $request->sort_by);
                if ($request->sort_by[0] == 1) {
                    $details->orderBy('price', 'DESC');
                }
                if ($request->sort_by[0] == 2) {
                    $details->orderBy('price', 'ASC');
                }
                if ($request->sort_by[0] == 3) {
                    $details->orderBy('created_at', 'DESC');
                }
                if ($request->sort_by[0] == 4) {
                    $details->orderBy('ratings', 'DESC');
                }
            }
            $product_detail_id = $details->groupBy('product_id')->get();
            $products = Product::query();
            foreach ($product_detail_id as $product_id) {
                $products->orWhere('id', $product_id->product_id);
            }

            // $product = collect([])
            $data['products'] = $products->where('active', '1')->paginate(3);
            // return $data;
        }
        // return $data;
        $data['creators'] = Creator::all();
        $data['categories'] = Category::all();
        $data['colors'] = Color::all();
        $data['sizes'] = Size::orderBy('name', 'ASC')->get();
        // notify()->success('Test');
        return view('frontend.product.product_list', $data);
    }

    public function filter(Request $request)
    {
        // if ($request->page) {
        //     return 'hi';
        // }
        $data = Product_detail::query();
        if ($request->category_id) {
            $request->session()->put('category_id', $request->category_id);
            $data->whereIn('category_id', $request->category_id);
        }
        if ($request->creator) {
            $request->session()->put(
                'creator_id',
                $request->creator
            );
            $data->whereIn('creator_id', $request->creator);
        }
        if ($request->discount) {
            $request->session()->put('discount', $request->discount);
            $data->where('discount', '>=', min($request->discount))->where('flat', '0');
        }
        if ($request->size) {
            $request->session()->put(
                'size',
                $request->size
            );
            $data->orWhereIn('size', $request->size);
        }
        if ($request->color) {
            $request->session()->put(
                'color',
                $request->color
            );
            $data->orWhereIn('color', $request->color);
        }
        if ($request->sort_by) {
            $request->session()->put('sort_by', $request->sort_by);
            if ($request->sort_by[0] == 1) {
                $data->orderBy('price', 'DESC');
            }
            if ($request->sort_by[0] == 2) {
                return $request->sort_by[0];
                $data->orderBy('price', 'ASC');
            }
            if ($request->sort_by[0] == 3) {
                $data->orderBy('created_at', 'DESC');
            }
            if ($request->sort_by[0] == 4) {
                $data->orderBy('ratings', 'DESC');
            }
        }
        $products = $data->groupBy('product_id')->paginate(3);
        if (count($products) <= 0) {
            $html = 'No Records Found...!';
            return $html;
        } else {
            $html = '<div class="row">';
            foreach ($products as $product) {
                $html .= '<div class="mb-4 col-xl-3 col-lg-4 col-md-6 col-sm-6 col-12">
                            <div class="product-list">
                                <div class="arrival-info">
                                    <a href=" ' . url('product/detail') . '/' . $product->product->id . ' ">
                                        <div class="product-img">
                                          <span class="wishlist favourite"';
                if (count($product->product->wish) > 0) {
                    $html .= 'style="display: none"';
                }
                $html .= 'data-id="' . $product->product->id . '">
                                                    <i class="fal fa-heart"></i>
                                                    <i class="fas fa-heart"></i>
                                            </span>
                                            <span class="wishlist un-favourite"';
                if (count($product->product->wish) <= 0) {
                    $html .= 'style="display: none"';
                }
                $html .= 'data-id="' . $product->product->id . '">
                                                <i class="fal fa-heart"></i>
                                                <i class="fas fa-heart"></i>
                                            </span>
                                            <figure>
                                                <img src="' . asset('public/assets/images/product') . '/' . $product->product->thumbnail . '"
                                                alt="product-image">
                                            </figure>
                                        </div>
                                        <div class="arrival-content">
                                            <h3>' . ucfirst($product->product->name) . '</h3>
                                            <div class="price-list"> <span class="grey-text">₹' . max(json_decode($product->product->regular_price)) . '</span>
                                                ₹' . min(json_decode($product->product->sale_price)) . '<span class="percent">Save ' . $product->product->discount;
                if ($product->product->flat == 1) {
                    $html .= '₹ Flat';
                } else {
                    $html .= '%';
                }
                $html .= '</span>
                                            </div>
                                        </div>
                                    </a>
                                </div>
                            </div>
                        </div>';
            }

            $html .= '</div>' . $products->links();
            return $html;
        }
    }

    public function detail(request $request, $id)
    {
        $data['data'] = Product::where('id', $id)
            ->with('product_detail')
            ->with('avgReview')
            ->first();
        $data['reviews'] = Ratings::all();
        $data['sizes'] = Size::all();
        $data['assets'] = Assets::all();
        $data['creators'] = Creator::get();
        // return $data['data']['product_detail'];
        $products = Product::where('category_id', $data['data']->category_id);

        $data['products'] = $products->get();
        return view('frontend.product.product_detail', $data);
    }



    public function productVariant(Request $request)
    {
        $data = Product_detail::where('product_id', $request->product)
            ->where('size', $request->size)
            ->where('color', $request->color)
            ->first();
        return $data;
    }

    public function get_color(Request $request)
    {
        $data = Product_detail::where('size', $request->size)->where('product_id', $request->product)->get();

        $html = '';
        foreach ($data as $i => $key) {
            $html .=  '<input type="radio" class="variant color"
                                                id="' . $key->color_id->id . $key->color_id->color_code . $i . '" name="color"
                                                value="' . $key->color_id->id . '">
                                            <label class="black"
                                                for="' . $key->color_id->id . $key->color_id->color_code . $i . '"
                                                style="background-color:' . $key->color_id->color_code . ';color:white"
                                                class="black"></label>
                                                ';
        }
        return $html . '<div class="error-message" id="error_msg_color" style="display:none">Please Select a Color.</div>';
    }

    public function notify(Request $request)
    {
        $data = new Notify;
        $data->size = $request->size;
        $data->email = $request->email;
        $data->save();
        return redirect()->back()->with('msg', 'Notify');
        // return $request;
    }
}