<?php

use App\Http\Controllers\Admin\HomeController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Api\CategoryController;
use App\Http\Controllers\Api\SubCategoryController;
use App\Http\Controllers\Api\ProductController;
use App\Http\Controllers\Api\RegisterController;
use App\Http\Controllers\Api\CartController;
use App\Http\Controllers\Api\CustomOrderController;
use App\Http\Controllers\Api\OrederController;
use App\Http\Controllers\Api\BannerController;
use App\Http\Controllers\Api\HeadingController;
use App\Http\Controllers\Api\LayoutController;
use App\Http\Controllers\Api\MediaController;
use App\Http\Controllers\Api\MediaInteractionController;
use App\Http\Controllers\Api\NewController;
use App\Http\Controllers\Api\ProductBannerController;
use App\Http\Controllers\Api\NotificationController;
use App\Http\Controllers\Api\SaveController;
use App\Http\Controllers\Api\SmsController;
use App\Http\Controllers\Api\VisionController;
use App\Http\Controllers\Api\EventViewController;
use App\Models\Customorder;
use App\Models\Notification;
use App\Models\Product_banners;
use Illuminate\Support\Facades\Auth;

use Symfony\Component\HttpKernel\DependencyInjection\RegisterControllerArgumentLocatorsPass;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| is assigned the "api" middleware group. Enjoy building your API!
|
*/

Route::post('test/send-otp', [SmsController::class, 'sendTestOtp']);

Route::get('/test', function () {
    return response()->json([
        'message' => 'Hello World! API is working',
        'status' => 'success',
        'timestamp' => now()
    ]);
});



Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
    return $request->user();
});

Route::post('category/list', [CategoryController::class, 'list'])->name('category_list');
Route::post('category/list/new', [CategoryController::class, 'category_list'])->name('category_list_new');
Route::post('category/add', [CategoryController::class, 'add'])->name('category_add');
Route::any('category/edit/{id}', [CategoryController::class, 'edit'])->name('category_edit');
Route::any('category/delete/{id}', [CategoryController::class, 'delete'])->name('category_delete');


// subcategory
Route::post('subcategory/list', [SubCategoryController::class, 'list']);
Route::post('all/subcategory/list', [SubCategoryController::class, 'all']);
Route::post('subcategory/add', [SubCategoryController::class, 'add']);
Route::any('subcategory/edit/{id}', [SubCategoryController::class, 'edit']);
Route::any('subcategory/delete/{id}', [SubCategoryController::class, 'delete']);
// subcategory

//productcontroller
Route::post('product/list/', [ProductController::class, 'list']);
Route::post('product/add/', [ProductController::class, 'add']);
Route::post('product/details/', [ProductController::class, 'details']);
Route::post('add/wishlist', [ProductController::class, 'wishlist']);
Route::post('remove/wishlist', [ProductController::class, 'remove_wishlist']);
Route::post('get/list', [ProductController::class, 'getlist']);
//productcontroller

//save master
// Route::post('get/qr', [SaveController::class, 'index']);
Route::post('get/qr', [SaveController::class, 'index_new']);
// Route::post('qr/save', [SaveController::class, 'add']);
Route::post('qr/save', [SaveController::class, 'add_new']);
Route::post('qr/delete', [SaveController::class, 'delete']);
//save master

Route::post('privacy-policy', [NotificationController::class, 'privacy']);
Route::post('terms', [NotificationController::class, 'terms']);

// registerController
Route::post('user/list', [RegisterController::class, 'list']);
Route::post('user/sign-up', [RegisterController::class, 'add']);
Route::post('user/login', [RegisterController::class, 'login']);
Route::post('user/logout', [RegisterController::class, 'logout']);
Route::post('request/otp', [RegisterController::class, 'requestOtp']);
Route::post('verify/otp', [RegisterController::class, 'verifyOtp']);
Route::post('disable/user', [RegisterController::class, 'disable']);
Route::post('login/check', [RegisterController::class, 'check']);
Route::post('user/verify-otp', [RegisterController::class, 'verifyOtp']);

// registerController

// Cart Controller
Route::post('add/cart', [CartController::class, 'add_cart']);
Route::post('view/cart', [CartController::class, 'view_cart']);
Route::post('delete/cart', [CartController::class, 'delete_cart']);
Route::post('cart/edit', [CartController::class, 'edit_cart']);
// Cart Controller

//orderControler
Route::post('order/list', [OrederController::class, 'order']);
Route::post('order/add', [OrederController::class, 'store']);

//orderControler

//new api for orders
Route::post('orders', [OrederController::class, 'order_list']);
Route::post('order/details', [OrederController::class, 'order_detail']);
Route::post('orderdetails', [OrederController::class, 'detail']);
//new api for orders

// customorder
Route::post('custom/list', [CustomOrderController::class, 'list']);
Route::post('custom/add', [CustomOrderController::class, 'add']);
// customorder

Route::post('media/list', [MediaController::class, 'list']);
Route::post('media/filter', [MediaController::class, 'filter']); // new one with filter
Route::post('media/like-count', [MediaInteractionController::class, 'likeCount']);
Route::post('media/add-comment', [MediaInteractionController::class, 'addComment']);
Route::post('media/comments', [MediaInteractionController::class, 'listComments']);
Route::post('media/like-toggle', [MediaInteractionController::class, 'toggleLike']);

// productbaner
Route::post('banner/list', [ProductBannerController::class, 'list']);
Route::post('get/advertise', [ProductBannerController::class, 'getAd']);
// productbaner

// notification
Route::post('notification/list', [NotificationController::class, 'list']);
Route::post('get/links', [NotificationController::class, 'links']);
Route::post('delete/user', [NotificationController::class, 'delete']);
Route::post('get/sizer', [NotificationController::class, 'sizer']);

// notification

Route::post('profile/update', [RegisterController::class, 'update']);
Route::post('offer/list', [ProductBannerController::class, 'offer']);
Route::post('social', [ProductBannerController::class, 'social']);


// new modules api
Route::post('stores', [NewController::class, 'store_list']);
Route::post('essentials', [NewController::class, 'essential_list']);
Route::post('collections', [NewController::class, 'collection_list']);
Route::post('headings', [HeadingController::class, 'heading_list']);
// new modules api


Route::get('layouts', [LayoutController::class, 'list']);
Route::get('layouts/inside', [LayoutController::class, 'list_name']);

Route::post('vision/analyze', [VisionController::class, 'analyze']);


Route::get('events', [EventViewController::class, 'index']);
Route::get('events/{id}', [EventViewController::class, 'show']);
Route::get('events/type/{type}', [EventViewController::class, 'byType']);

Auth::routes();
