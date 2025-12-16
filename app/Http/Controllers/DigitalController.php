<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Assets;
use App\Models\Banner;
use App\Models\Creator;
use App\Models\Category;
use App\Models\Color;
use App\Models\Size;
use App\Models\View;
use Illuminate\Support\Facades\Auth;

class DigitalController extends Controller
{
    public function index(Request $request)
    {
        if ($request->filter) {
            $assets = Assets::query();
            if ($request->category) {
                $assets->whereIn('category_id', $request->category);
            }
            if ($request->color) {
                $assets->whereIn('color_id', $request->color);
            }
            if ($request->creator) {
                $assets->whereIn('creator_id', $request->creator);
            }
            if ($request->design) {
                $assets->whereIn('id', $request->design);
            }
            if ($request->free_paid) {
                if ($request->free_paid == 2) {
                    $assets->where('free', '0');
                }
                if ($request->free_paid == 1) {
                    $assets->where('free', '1');
                }
            }
            if ($request->sort_by) {
                if ($request->sort_by[0] == 1) {
                    $assets->orderBy('sale', 'DESC');
                }
                if ($request->sort_by[0] == 2) {
                    $assets->orderBy('sale', 'ASC');
                }
                if ($request->sort_by[0] == 3) {
                    $assets->orderBy('created_at', 'DESC');
                }
                if ($request->sort_by[0] == 4) {
                    $assets->orderBy('ratings', 'DESC');
                }
            }
            $data['filters'] = $request->all();
            $data['data'] = $assets->paginate(2);
        } else {
            $data['data'] = Assets::paginate(2);
        }
        $data['assets'] = Assets::all();
        $data['creators'] = Creator::all();
        $data['categories'] = Category::all();
        $data['colors'] = Color::all();
        $data['banners'] = Banner::first();
        // $data['assets'] = Asset::where('id', $id)->first();
        return view('frontend.digital.digital_list', $data);
    }

    public function detail(request $request, $id)
    {
        $data['data'] = Assets::where('id', $id)
            ->first();

        $assets = Assets::where('creator_id', $data['data']->creator_id);
        if ($data['data']['related']) {
            $assets->whereIn('id', json_decode($data['data']['related']));
        }
        $data['assets'] =  $assets->get();

        $data['digitals'] = Assets::all();

        return view('frontend.digital.digital_add', $data);
    }

    public function filter(Request $request)
    {
        $data = Assets::query();
        if ($request->category) {
            $data->whereIn('category_id', $request->category);
        }
        if ($request->color) {
            $data->whereIn('color_id', $request->color);
        }
        if ($request->creator) {
            $data->whereIn('creator_id', $request->creator);
        }
        if ($request->design) {
            $data->whereIn('id', $request->design);
        }
        if ($request->sort_by) {
            if ($request->sort_by == 1) {
                $data->orderBy('sale', 'DESC');
            }
            if ($request->sort_by == 2) {
                $data->orderBy('sale', 'ASC');
            }
            if ($request->sort_by == 3) {
                $data->orderBy('created_at', 'DESC');
            }
            if ($request->sort_by == 4) {
                $data->orderBy('ratings', 'DESC');
            }
        }
        $assets = $data->get();
        // return $asset;
        if (count($assets) <= 0) {
            $html = 'No Record Found....!!';
            return $html;
        } else {
            $html = '<div class="row digital-assets-list">';
            foreach ($assets as $asset) {
                $html .= '<div class="mb-4 col-xl-3 col-lg-4 col-md-6 col-sm-6 col-12">
                                                <div class="product-list product-list-digital">
                                                    <div class="arrival-info">
                                                        <a href="' . url('digital/assets/detail') . '/' . $asset->id . '">
                                                            <div class="product-img">
                                                                <span class="wishlist favourite"';
                if (count($asset->wish) > 0) {
                    $html .= 'style="display: none"';
                }
                $html .= 'asset-id="' . $asset->id . '">  <i class="fal fa-heart"></i>
                                                          <i class="fas fa-heart"></i>
                                                                </span>
                                                                <span class="wishlist un-favourite"';
                if (count($asset->wish) <= 0) {
                    $html .= ' style="display: none"';
                }
                $html .= 'asset-id="' . $asset->id . '">    <i class="fal fa-heart"></i>
                                                        <i class="fas fa-heart"></i></span>
                                                                <figure>
                                                                    <img src="' . asset("public/assets/images/digitalassets") . "/" . $asset->image . '"
                                                                        alt="product-image">
                                                                </figure>
                                                            </div>
                                                            <div class="arrival-content">
                                                                <h3>' . ucfirst($asset->name) . '</h3>
                                                                <div
                                                                    class="d-flex align-items-center justify-content-between">
                                                                    <div class="price-list">
                                                                        <span class="price">
                                                                            ₹' . $asset->sale . '
                                                                        </span>
                                                                        <div>
                                                                            <span
                                                                                class="grey-text">₹' . $asset->regular_price . '</span>
                                                                            <span class="percent">Save
                                                                                ' . $asset->discount;
                if ($asset->flat == 1) {
                    $html .= " Flat";
                } else {
                    $html .= "%";
                }
                $html .= '</span>  </div>
                                                                    </div>

                                                                    <div class="created-by">
                                                                        <span class="crerated-img">
                                                                            <img src="' . asset("public/assets/images/digitalassets") . "/" . $asset->image . '"
                                                                                alt="product-image">
                                                                        </span>
                                                                        <div class="text">
                                                                            <span class="gray-text">Created by</span>
                                                                            <span class="name">
                                                                                @
                                                                                ' . ucfirst($asset->creator->user->name) . '</span>
                                                                        </div>
                                                                    </div>
                                                                </div>
                                                            </div>
                                                            <div class="overlay-img">
                                                                <span class="wishlist favourite"';
                if (count($asset->wish) > 0) {
                    $html .= ' style="display: none" ';
                }
                $html .= 'asset-id="' . $asset->id . '">
                                                                    <i class="fal fa-heart"></i>
                                                                    <i class="fas fa-heart"></i>
                                                                </span>
                                                                <span class="wishlist un-favourite"';
                if (count($asset->wish) <= 0) {
                    $html .= 'style="display: none"';
                }
                $html .= 'asset-id="' . $asset->id . '"><i class="fal fa-heart"></i>
                                                <i class="fas fa-heart"></i></span>
                                                                <figure>
                                                                    <img src="' . asset("public/assets/images/digitalassets") . "/" . $asset->image . '"
                                                                        alt="product-image">
                                                                </figure>
                                                            </div>
                                                        </a>
                                                    </div>
                                                </div>
                                            </div>';
            }
            $html .= '</div>';
            return $html;
        }
    }

    public function get_detail(Request $request)
    {
        $data = Assets::where('id', $request->asset_id)->first();
        return $data;
    }


    public function digital_asset(request $request)
    {
        $data = new View;
        $data->asset_id =  $request->id;
        $data->save();
        $data = Assets::find($request->id);
        // return $data;

        $html = '';
        $html .= '<div class="digital-assets-detail">
                            <div class="row">
                                <div class="col-lg-6">
                                    <div class="digital-assets-slider">
                                        <div class="stripe">';
        $html .= ' <img src=" ' . asset('public/assets/images/digital-assets-ribbion-shadow.png') . ' "
                                                alt="">
                                                </div>
                                                <div class="on-hover-icon">
                                            <img src=" ' . asset('public/assets/images/ic-smartphone.png') . ' " alt="">       
                                        </div>';
        if ($data->gallery) {
            $image = json_decode($data->gallery);
            $html .= ' <div class="product-slider">
                                            <div class="slider slider-for">';
            $html .= ' <div>
                                                    <div class="product-img">
                                                     <img src="' . asset("public/assets/images/digitalassets") . "/" . $data->image . '"
                                                            alt="product-image">
                                                    </div>
                                                </div>';
            foreach ($image as $image) {
                $html .= ' <div>
                                                    <div class="product-img">
                                                     <img src="' . asset("public/assets/images/digitalassets") . "/" . $image . '"
                                                            alt="product-image">
                                                    </div>
                                                </div>';
            }
        }
        $html .= '</div>
                                        </div>
                                    </div>
                                </div>';

        $html .= '<div class="col-lg-6">
                                    <div class="digital-assets-detail-content">
                                        <div class="product-content">
                                            <!-- Breadcrumb and Wishlist -->
                                            <div class="breadcrumb-favourite">
                                                <div class="breadcrumb-view-favourite">
                                                    <div class="breadcrumb-sec">
                                                        <nav aria-label="breadcrumb">
                                                            <ol class="breadcrumb">
                                                                <li class="breadcrumb-item"><a href="' . url('/') . '">Home</a></li>
                                                                <li class="breadcrumb-item active" aria-current="page">
                                                                    Digital Assets</li>
                                                            </ol>
                                                        </nav>
                                                    </div>
                                                    <div class="views-favourite">
                                                        <a class="total-view" href="#">
                                                            <i class="fas fa-eye"></i>
                                                            <span class="views">' . count($data->view) . ' Views</span>
                                                        </a>
                                                        <a class="total-favourite" href="#">
                                                            <i class="fas fa-heart"></i>
                                                            <span class="favourite-list">' . count($data->wish_count) . ' favourite</span>
                                                        </a>
                                                    </div>
                                                </div> 
                                                <div class="wishlist-star">
                                                    
                                                        <span class="wishlist ' . (count($data->wish) > 0 ? 'un-favourite' : 'favourite') . '" asset-id="' . $data->id . '">
                                                            <i class="fal fa-heart"></i>
                                                            <i class="fas fa-heart"></i>
                                                        </span>
                                                   
                                                </div>
                                            </div>';
        if ($data->avgReview) {
            $html .= '<div id="stars-group">
                                            <div class="rating-group">';
            for ($i = 0; $i < intVal($data->avgReview); $i++) {
                $html .= '<i class="fas fa-star text-warning" aria-hidden=""></i>&nbsp;';
            }
            $html .= '</div></div>';
        }
        $html .= '<div class="title-rating"><div class="product-title"><h3>' . ucfirst($data->name) . '</h3><p>' .  htmlspecialchars_decode($data->product_details) . '</p>
                                                </div>
                                            </div>';

        if ($data->sponserd) {
            $html .= '<div class="mb-4 text-right"><span class="mb-3 sponsored-tag">
                                            Design Sponsored by <a href="' . url('sponsored-brand') . '"> <b>' . ucfirst($data->sponserd) . '</b> </a>
                                        </span></div>';
        }
        $html .= '<div class="created-by-connect">
                                                <div class="created-by-connect-wrap">
                                                    <!-- Created by -->
                                                    <div class="created-by">
                                                        <span class="crerated-img">
                                                            <img src="' . asset("public/assets/images/creators") . "/" . $data->creator->user->image . '"
                                                                alt="product-image">
                                                        </span>
                                                        <div class="text-btn">
                                                            <div class="text">
                                                                <span class="gray-text">Created by</span>
                                                                <span class="name">' . ucfirst($data->creator->user->name) . '</span>
                                                            </div>
                                                            <a href="javascript:void(0);" id="" class="btn btn-black-brd followBtn';
        if (count($data->follow) > 0) {
            $html .= ' following "';
        } else {
            $html .= ' follow "';
        }
        if (count($data->follow) > 0) {
            $html .= ' style="background: rgb(252, 236, 2);"';
        }
        $html .= '  data-user-id="' . $data->user->id . '" data-creator-id="' . $data->creator->user->id . '">';
        if (count($data->follow) > 0) {
            $html .= 'Following';
        } else {
            $html .= 'Follow';
        }
        $html .= ' </a>
                                                            
                                                        </div>
                                                    </div>
                                                    <!-- Social icon -->
                                                    <div class="share-social">
                                                        <div class="social-links">
                                                            <p>Connect with Artist</p>
                                                            <div class="social-icon">
                                                                <ul>
                                                                    <li>
                                                                        <a href="' . $data->creator->facebook . '">
                                                                            <i class="fab fa-facebook-f"></i>
                                                                        </a>
                                                                    </li>
                                                                    <li>
                                                                        <a href="' . $data->creator->instagram . '">
                                                                            <i class="fab fa-instagram"></i>
                                                                        </a>
                                                                    </li>
                                                                    <li>
                                                                        <a href="' . $data->creator->youtube . '">
                                                                            <i class="fab fa-youtube"></i>
                                                                        </a>
                                                                    </li>
                                                                </ul>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                            ';

        // if (count($data->follow) == 0) {
        $html .= '<div id="followNotificationMessage" style="display:none;">
                                                                    <div class="aliean-img">
                                                                        <img src="' . asset('public/assets/images/aliean-img.png') . ' " alt="product-image">
                                                                    </div> <div class="notification-text">
                                                                        <h6>Hey, <span></span></h6>
                                                                        <p>kudos for showing </p>
                                                                        <p>your support for artists like me! </p>
                                                                        <p>You can pin my profile in the Artists Corner, and of course, follow numerous  AlagSEE designers at once! </p>
                                                                    </div>';

        $html .=   ' <div class="space-img">
                                                                        <img src=" ' . asset('public/assets/images/space-img.png') . '" alt="product-image">
                                                                    </div>
                                                            </div>
                                            ';
        // }
        $html .= '<div class="price-list">
                                                <span id="sale_price_span">';
        if ($data->sale) {
            $html .= ' ₹' . $data->sale . '';
        } else {
            $html .= ' ₹ 0';
        }

        if ($data->regular_price) {
            $html .= '      </span>
                                                <span class="grey-text mr-2" id="regular_price_span">₹' . $data->regular_price . '</span>';
        }

        $html .= '    <span class="percent" id="discount_span">';
        if ($data->discount) {
            $html .= 'Save ';
            $html .= '' . $data->discount . '';
            $html .= ' ' . $data->flat == 1 ? "₹ FLAT" : "%" . '';
            $html .= ' OFF';
        }
        $html .= ' </span> </div>';

        $html .= '<div class="btn-group">
                                                <button class="yellow-btn add_cart" id="cart_button">
                                                    <div class="button_inner"><span data-text="Add to Cart" style="cursor: pointer">Add to
                                                            Cart</span></div>
                                                </button>
                                                <a href="#" class="yellow-btn" id="buy_now">
                                                    <div class="button_inner"><span data-text="Buy Now">Buy Now</span>
                                                    </div>
                                                </a>
                                            </div>';
        $html .= '<div class="mt-4 pincode-sharing">';
        if (Auth::check()) {
            $html .= '   <h6>Available Digital Asset Slots - 10</h6>';
        }
        $html .= '    <div class="btn-group">';
        if (Auth::check()) {
            // $html .= '<a href="#" class="yellow-btn" id="">
            //                                         <div class="button_inner"><span data-text="Login to view Assets Slots">Login to view Assets Slots</span>
            //                                         </div>
            //                                     </a></div>';
        } else {
            $html .= '<a href="#" class="yellow-btn" id="" data-toggle= "modal" data-target="#authLoginModal">
                                                    <div class="button_inner"><span data-text="Login to view Assets Slots">Login to view Assets Slots</span>
                                                    </div>
                                                </a></div>';
        }
        $html .= '<div class="pincode-input d-none">
                                                    <input class="form-control" type="text" placeholder="Enter Mobile Numer">
                                                    <button class="btn btn-check">Check</button>
                                                </div>
                                            </div>
                                        </div>';

        $html .= '<div class="product-slider">
                                            <div class="slider slider-nav">';
        if ($data->gallery) {

            $image = json_decode($data->gallery);
            $html .= ' <div>
                                                    <div class="product-thumb">
                                                     <img src="' . asset("public/assets/images/digitalassets") . "/" .  $data->image . '"
                                                            alt="product-image">
                                                    </div>
                                                </div>';
            foreach ($image as $image) {
                $html .= ' <div>
                                                    <div class="product-thumb">
                                                     <img src="' . asset("public/assets/images/digitalassets") . "/" . $image . '"
                                                            alt="product-image">
                                                    </div>
                                                </div>';
            }
        }
        $html .= ' </div>
                                        </div>
                                        <!-- Watch Video -->
                                        <div class="watch-video-sec">
                                            <span class="sub-title">What is Digital Assets?</span>
                                            <a href="#" class="watch-video">
                                                Watch Video <i class="fas fa-play-circle"></i>
                                            </a>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            
        ';


        $html .= '<form action="" id="cart-form">
                <input type="hidden" value="' . $data->id . '" id="asset_id" name="asset_id">
                <input type="hidden" value="' . $data->sale . '" id="sale_price" name="sale_price">
                <input type="hidden" value="' . $data->regular_price . '" id="regular_price" name="regular_price">
                <input type="hidden" value="' . $data->discount . '" id="discount" name="discount">
                <input type="hidden" value="' . $data->flat . '" id="flat" name="flat">
                <input type="hidden" value="' . "1" . '" name="quantity" id="quantity">
            </form></div>';


        return $html;
    }
}
