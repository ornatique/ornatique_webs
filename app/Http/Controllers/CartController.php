<?php

namespace App\Http\Controllers;

use App\Models\Assets;
use Illuminate\Http\Request;
use App\Models\Cart;
use App\Models\Wishlist;
use App\Models\Product;
use App\Models\Category;
use App\Models\Color;
use App\Models\Product_detail;
use Illuminate\Support\Facades\Auth;

class CartController extends Controller
{
    public function index(Request $request)
    {
        // return $request;
        if (Auth::check()) {
            $data['data'] = Cart::where('user_id', Auth::id())->get();
        } else {
            $data['data'] = Cart::where('user_id', $request->ip())->get();
        }
        return view('frontend.cart', $data);
    }

    public function wishlist(Request $request)
    {
        if (Auth::check()) {
            $data['datas'] = Wishlist::with('product')->with('asset')->where('user_id', Auth::id())->get();
            $data['products'] = Wishlist::where('product_id', '!=', '')->where("user_id", Auth::id())->count();
            $data['assets'] = Wishlist::where('asset_id', '!=', '')->where("user_id", Auth::id())->count();
        } else {
            $data['datas'] = Wishlist::with('product')->with('asset')->where('user_id', $request->ip())->get();
            $data['products'] = Wishlist::where('product_id', '!=', '')->where("user_id", $request->ip())->count();
            $data['assets'] = Wishlist::where('asset_id', '!=', '')->where("user_id", $request->ip())->count();
        }
        // return $data;
        return view('frontend.wishlist', $data);
    }

    public function add_wishlist(Request $request)
    {
        $data = new Wishlist;
        if ($request->id) {
            $data->product_id = $request->id;
        }
        if ($request->asset_id) {
            $data->asset_id = $request->asset_id;
        }
        if (Auth::check()) {
            $data->user_id = Auth::id();
        } else {
            $data->user_id = $request->ip();
        }
        $data->save();
        return $request;
    }



    public function cart_to_wishlist(Request $request)
    {
        // return $request;
        $data = new Wishlist;
        if ($request->id) {
            $data->product_id = $request->id;
        }
        if ($request->asset_id) {
            $data->asset_id = $request->asset_id;
        }
        if (Auth::check()) {
            $data->user_id = Auth::id();
        } else {
            $data->user_id = $request->ip();
        }
        $data->save();
        if ($request->move) {
            $cart = Cart::query();
            if ($request->asset_id) {
                $cart->where('asset_id', $request->asset_id);
            }
            if ($request->id) {
                $cart->where('product_id', $request->id);
            }
            if (Auth::check()) {
                $cart->where('user_id', Auth::id());
            } else {
                $cart->where('user_id', $request->ip());
            }
            $cart->delete();
        }
        return $request;
    }


    public function remove_wishlist(Request $request)
    {
        $data = Wishlist::query();
        if ($request->id) {
            if (Auth::check()) {
                Wishlist::where('user_id', Auth::id())->where('product_id', $request->id)->delete(); //Auth::id();
            } else {
                Wishlist::where('user_id', $request->ip())->where('product_id', $request->id)->delete(); //Auth::id();
            }
        }
        if ($request->asset_id) {
            if (Auth::check()) {
                Wishlist::where('user_id', Auth::id())->where('asset_id', $request->asset_id)->delete(); //Auth::id();
            } else {
                Wishlist::where('user_id', $request->ip())->where('asset_id', $request->asset_id)->delete(); //Auth::id();
            }
        }
        return $request;
    }



    public function insert(request $request)
    {
        // return $request;
        if ($_POST) {
            $data = new Cart;
            $data->asset_id = $request->asset_id;
            if (Auth::check()) {
                $data->user_id = Auth::id();
            } else {
                $data->user_id = $request->ip();
            }
            $data->sale_price = $request->sale_price;
            $data->regular_price = $request->regular_price;
            if ($request->discount) {
                $data->discount = $request->discount;
            }
            $data->flat = $request->flat;
            $data->quantity = $request->quantity;
            $data->product_id = $request->product_id;
            $data->size_id = $request->size;
            $data->color_id = $request->color;
            $data->category_id = $request->category;
            // return $data;
            $data->save();
            if ($request->product_id) {
                Wishlist::where('product_id', $request->product_id)->delete();
            }
            if ($request->asset_id) {
                Wishlist::where('asset_id', $request->asset_id)->delete();
            }
            return 'Product is Added to Cart!';
        }
    }

    public function insert_asset(Request $request)
    {
        $data = Assets::where('id', $request->id)->first();
        $cart = new Cart;
        $cart->asset_id = $data->id;
        $cart->sale_price = $data->sale;
        $cart->regular_price = $data->regular_price;
        $cart->discount = $data->discount;
        $cart->flat = $data->flat;
        if (Auth::check()) {
            $cart->user_id = Auth::id();
        } else {
            $cart->user_id = $request->ip();
        }
        $cart->quantity = '1';

        $cart->save();
        Wishlist::where('asset_id', $request->id)->delete();
        return;
    }

    public function remove_cart(request $request)
    {
        if ($_POST) {
            Cart::where('id', $request->id)->delete();
            return redirect()->route('cart');
            return view('frontend.home');
        }
    }

    public function productVariant(Request $request)
    {
        $data = wishlist::where('product_id', $request->product)
            ->where('size', $request->size)
            ->where('color', $request->color)
            ->first();
        // if (count($data) >= 0) {
        //     return 'This Variant is Not available...!!!!';
        // };
        return $data;
    }

    public function get_size(Request $request)
    {

        $data = Product_detail::where('product_id', $request->product_id)->groupBy('size')->get();
        $html = '';
        foreach ($data as $key) {
            $html .= '<input type="radio" id="' . $key->size_id->name . '" class="variant size" name="size" value="' . $key->size_id->id . '">
                        <label for="' . $key->size_id->name . '">' . ucfirst($key->size_id->name) . '</label>';
        }

        return $html;
    }

    public function get_color(Request $request)
    {
        $data = Product_detail::where('product_id', $request->product_id)->where('size', $request->size)->get();
        // return $data;
        $html = '';
        foreach ($data as $key) {
            $html .= '<input type="radio" class="variant color" id="' . $key->color_id->color_code . '" name="color" value="' . $key->color_id->id . '">
                                    <label class="" style="background-color:' .
                $key->color_id->color_code . '" for="' . $key->color_id->color_code . '"></label>';
        }
        return $html;
    }

    public function remove_list(Request $request)
    {
        $data = Wishlist::where('id', $request->id)->delete();
        return redirect()->route('cart');
        return view('frontend.home');
    }

    public function delete_selected_cart(Request $request)
    {
        $ids =  explode(",", $request->id);
        foreach ($ids as $id) {
            Cart::where('id', $id)->delete();
        }
        return redirect()->back();
    }

    public function change_size(Request $request)
    {

        $data = Cart::find($request->cart_id);
        $data->size_id = $request->size_id;
        $product = Product_detail::where('product_id', $data->product_id)->where('size', $request->size_id)->where('color', $request->color_id)->first();
        if (!$product) {
            return 'Your color is not available in this size';
        }
        $data->sale_price = $product->price;
        $data->regular_price = $product->regular_price;
        $data->discount = $product->discount;
        $data->flat = $product->flat;
        $data->save();
        return '';
        // return  $product;
    }
}