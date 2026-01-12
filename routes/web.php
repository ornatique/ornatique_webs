<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Admin\HomeController;
use App\Http\Controllers\Admin\CategoryController;
use App\Http\Controllers\Admin\SubcategoryController;
use App\Http\Controllers\Admin\ProductController;
use App\Http\Controllers\Admin\UserController;
use App\Http\Controllers\Admin\OrederController;
use App\Http\Controllers\Admin\PermissionController;
use App\Http\Controllers\Admin\BannerController;
use App\Http\Controllers\Admin\CollectionController;
use App\Http\Controllers\Admin\CustomOrderController;
use App\Http\Controllers\Admin\EssentialController;
use App\Http\Controllers\Admin\HeadingController;
use App\Http\Controllers\Admin\LayoutController;
use App\Http\Controllers\Admin\LayoutNameController;
use App\Http\Controllers\Admin\ProductBannerController;
use App\Http\Controllers\Admin\LinkController;
use App\Http\Controllers\Admin\MediaController;
use App\Http\Controllers\Admin\OfferController;
use App\Http\Controllers\Admin\SocialController;
use App\Http\Controllers\Admin\StoreCollection;
use App\Http\Controllers\Admin\TaskController;
use App\Http\Controllers\WebNotificationController;
use App\Http\Controllers\Admin\EventController;
use App\Models\Custum_order;
use App\Models\Privacy;
use Illuminate\Support\Facades\Auth;
/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/

Route::get('/', function () {
    return redirect()->route('admin_home');
});
Route::get('/privacy-policy', function () {
    $data =  Privacy::first();
    return htmlspecialchars_decode($data->privacy);
    return redirect()->route('admin_home');
});


Route::get('/test-fcm', function () {
    $token = 'dNcn4dYsQECP3vTeDOpOZL:APA91bHV4p0vYLbdWOTyz4D1YwHdGdq5KNAmR24aIk6PhEE7qhhxa7eMmiDy-S3rmM5xCjzXMBR7pJC20EUf2P-AwNZApiLEDmTI0BzNs99A90G2aXQDDoE';
    $response = \App\Helpers\FCMManualHelper::sendPush($token, 'Testing Title', 'This is a test');
    return $response;
});

Auth::routes();

Route::get('/home', [App\Http\Controllers\HomeController::class, 'index'])->name('home');
Route::post('order/detail/{name}', [HomeController::class, 'detail']);
Route::post('/get-cities', [UserController::class, 'getCities'])->name('get.cities');

// Auth::routes();

// Route::get('/home', [App\Http\Controllers\HomeController::class, 'index'])->name('home');

Route::group(
    [
        'prefix' => 'admin',
        'namespace' => 'Admin',
        'as' => 'admin_',
        'middleware' => ['auth']
    ],
    function () {
        Route::get('/dashboard', [HomeController::class, 'index'])->name('home');
        Route::get('order/detail/{name}', [HomeController::class, 'detail']);

        Route::get('custom/notificaion', [TaskController::class, 'index']);
        Route::any('custom/add', [TaskController::class, 'add']);
        Route::any('custom/edit/{id}', [TaskController::class, 'edit']);
        Route::post('custom/delete', [TaskController::class, 'delete']);
        Route::get('custom/resend/{id}', [TaskController::class, 'resend'])->name('task.resend');


        Route::get('privacy-policy', [HomeController::class, 'privacy_policy'])->name('privacy_policy');
        Route::any('privacy-policy/edit', [HomeController::class, 'privacy_policy_edit'])->name('privacy_policy_edit');
        // Route::any('privacy-policy/edit', [HomeController::class, 'privacy_policy_edit'])->name('privacy_policy_edit');

        Route::get('students/list', [ProductController::class, 'getStudents'])->name('students_list');


        // Category Controller
        Route::get('category/list', [CategoryController::class, 'list'])->name('category_list');
        Route::any('category/add', [CategoryController::class, 'add']);
        Route::any('category/edit/{id}', [CategoryController::class, 'edit']);
        Route::post('category/delete', [CategoryController::class, 'delete']);
        // Category Controller

        // Category Controller
        Route::get('offer/list', [OfferController::class, 'list'])->name('offer_list');
        Route::any('offer/add', [OfferController::class, 'add']);
        Route::any('offer/edit/{id}', [OfferController::class, 'edit']);
        Route::post('offer/delete', [OfferController::class, 'delete']);
        // Category Controller

        Route::get('layouts', [LayoutController::class, 'index'])->name('layouts.index');
        Route::any('layouts/add', [LayoutController::class, 'add'])->name('layouts.add');
        Route::any('layouts/edit/{id}', [LayoutController::class, 'edit'])->name('layouts.edit');
        Route::post('layouts/delete', [LayoutController::class, 'delete'])->name('layouts.delete');
        Route::post('layouts/status', [LayoutController::class, 'updateStatus'])->name('layouts.status');


        //subcategory master
        Route::get('subcategory/list', [SubcategoryController::class, 'index'])->name('subcategory_list');
        Route::any('subcategory/add', [SubcategoryController::class, 'add']);
        Route::any('subcategory/edit/{id}', [SubcategoryController::class, 'edit'])->name('subcategory_edit');
        Route::post('subcategory/delete', [SubcategoryController::class, 'delete']);
        //subcategory master

        //Product master
        Route::get('product/list', [ProductController::class, 'list'])->name('product_list');
        Route::any('product/add', [ProductController::class, 'add']);
        Route::any('product/edit/{id}', [ProductController::class, 'edit']);
        Route::post('product/delete', [ProductController::class, 'delete']);
        Route::post('get-subcategory', [SubcategoryController::class, 'get_sub']);
        Route::post('/upload-image', [ProductController::class, 'upload']);
        //Product master


        Route::get('comment/list', [MediaController::class, 'list_comment'])->name('comment_list');
        Route::any('comment/edit/{id}', [MediaController::class, 'comment_edit']);
        Route::get('like/list', [MediaController::class, 'list_like'])->name('like_list');

        Route::get('media/list', [MediaController::class, 'list'])->name('media_list');
        Route::any('media/add', [MediaController::class, 'add']);
        Route::any('media/edit/{id}', [MediaController::class, 'edit']);
        Route::post('media/delete', [MediaController::class, 'delete']);
        Route::post('comment/delete', [MediaController::class, 'comment_delete']);
        Route::post('comment/update', [MediaController::class, 'comment_edit'])->name('comment.update');

        // Route::post('get-subcategory', [SubcategoryController::class, 'get_sub']);
        // Route::post('/upload-image', [ProductController::class, 'upload']);

        //usermaster
        Route::get('user/list', [UserController::class, 'list'])->name('user_list');
        Route::any('user/add', [UserController::class, 'add'])->name('user_add');
        Route::any('user/edit/{id}', [UserController::class, 'edit'])->name('user_edit');
        Route::post('user/delete', [UserController::class, 'delete'])->name('user_delete');

        Route::get('user/role', [UserController::class, 'index'])->name('track_list');
        Route::post('user_role', [UserController::class, 'user_role']);
        //usermaster

        //oreder
        Route::get('order/list', [OrederController::class, 'list'])->name('order_list');
        Route::post('order/detail/{name}', [OrederController::class, 'detail']);
        Route::any('order/edit/{id}', [OrederController::class, 'edit'])->name('order_edit');
        Route::post('order/delete', [OrederController::class, 'delete']);

        Route::post('ajaxStatusChange', [App\Http\Controllers\Admin\HomeController::class, 'ajaxStatusChange']);
        Route::post('ajaxStatusChangeAdmin', [App\Http\Controllers\Admin\HomeController::class, 'ajaxStatusChangeAdmin']);
        Route::post('orderStatusChange', [App\Http\Controllers\Admin\HomeController::class, 'orderStatusChange']);
        //oreder
        // permission
        Route::get('permission/list', [PermissionController::class, 'list'])->name('permission_list');
        Route::any('permission/add', [PermissionController::class, 'add'])->name('permission_add');
        Route::any('permission/edit/{id}', [PermissionController::class, 'edit'])->name('permission_edit');
        Route::post('permission/delete', [PermissionController::class, 'delete'])->name('permission_delete');
        // permission

        // banner
        Route::get('banner', [BannerController::class, 'index'])->name('banners');
        Route::any('banners/list', [BannerController::class, 'list'])->name('banners');
        Route::get('banner', [BannerController::class, 'index'])->name('banners');
        Route::any('banners', [BannerController::class, 'edit'])->name('banners_edit');
        Route::post('upload/banners', [BannerController::class, 'upload']);
        // banner

        // links
        Route::get('link/list', [LinkController::class, 'list'])->name('links_list');
        Route::any('link/add', [LinkController::class, 'add'])->name('links_add');
        Route::any('link/edit/{id}', [LinkController::class, 'edit'])->name('links_edit');
        Route::post('link/delete', [LinkController::class, 'delete'])->name('links_delete');
        // links

        // links
        Route::get('social/list', [SocialController::class, 'list'])->name('social_list');
        Route::any('social/add', [SocialController::class, 'add'])->name('social_add');
        Route::any('social/edit/{id}', [SocialController::class, 'edit'])->name('social_edit');
        Route::post('social/delete', [SocialController::class, 'delete'])->name('social_delete');
        // links

        Route::get('product/banners', [ProductBannerController::class, 'index'])->name('product_banners');
        Route::any('product/banners/add', [ProductBannerController::class, 'add'])->name('products_add');
        Route::any('product/banner/edit/{id}', [ProductBannerController::class, 'edit'])->name('products_edit');
        Route::post('product/banners/delete', [ProductBannerController::class, 'delete'])->name('products_delete');

        Route::get('custumer/list', [HomeController::class, 'list']);
        Route::get('custumer/new-list', [HomeController::class, 'new_list']);

        // customorders
        Route::get('custum/list', [CustomOrderController::class, 'list'])->name('custum_list');
        Route::any('custum/add', [CustomOrderController::class, 'add'])->name('custum_add');
        Route::any('custum/edit/{id}', [CustomOrderController::class, 'edit'])->name('custum_edit');
        Route::post('custum/delete', [CustomOrderController::class, 'delete'])->name('custum_delete');
        // customorders

        Route::get('/order/invoice/{name}', [App\Http\Controllers\Admin\HomeController::class, 'invoice'])->name('invoice');
        Route::get('/order/pdf/{name}', [App\Http\Controllers\Admin\HomeController::class, 'pdf'])->name('pdf');
        Route::get('/print/qr/{name}', [App\Http\Controllers\Admin\HomeController::class, 'qr'])->name('qr');
        Route::get('/print/qrs', [App\Http\Controllers\Admin\HomeController::class, 'qrs']);
        Route::get('/custom-order/invoice/{id}', [App\Http\Controllers\Admin\HomeController::class, 'custom_invoice'])->name('custom_invoice');

        Route::get('/notificaiton/list', [WebNotificationController::class, 'list'])->name('notificaiton_list');
        Route::post('/notificaiton/delete', [WebNotificationController::class, 'delete'])->name('notification.delete');

        Route::any('/push-notificaiton', [WebNotificationController::class, 'index'])->name('push-notificaiton');

        Route::prefix('essential')->group(function () {
            Route::get('/list', [EssentialController::class, 'list'])->name('essential_list');
            Route::match(['get', 'post'], '/add', [EssentialController::class, 'add'])->name('essential_add');
            Route::match(['get', 'post'], '/edit/{id}', [EssentialController::class, 'edit'])->name('essential_edit');
            Route::post('/delete', [EssentialController::class, 'delete'])->name('essential_delete');
        });

        Route::prefix('collection')->group(function () {
            Route::get('/list', [CollectionController::class, 'list'])->name('collection_list');
            Route::match(['get', 'post'], '/add', [CollectionController::class, 'add'])->name('collection_add');
            Route::match(['get', 'post'], '/edit/{id}', [CollectionController::class, 'edit'])->name('collection_edit');
            Route::post('/delete', [CollectionController::class, 'delete'])->name('collection_delete');
        });


        Route::prefix('store')->group(function () {
            Route::get('/list', [StoreCollection::class, 'index'])->name('store_list');
            Route::match(['get', 'post'], '/add', [StoreCollection::class, 'add'])->name('store_add');
            Route::match(['get', 'post'], '/edit/{id}', [StoreCollection::class, 'edit'])->name('store_edit');
            Route::post('/delete', [StoreCollection::class, 'delete'])->name('store_delete');
        });

        Route::prefix('heading')->group(function () {
            Route::get('/list', [HeadingController::class, 'index'])->name('heading_list');
            Route::match(['get', 'post'], '/add', [HeadingController::class, 'add'])->name('heading_add');
            Route::match(['get', 'post'], '/edit/{id}', [HeadingController::class, 'edit'])->name('heading_edit');
            Route::post('/delete', [HeadingController::class, 'delete'])->name('heading_delete');
        });

        // Show all layout names
        Route::prefix('layout-names')->group(function () {
            Route::get('/list', [LayoutNameController::class, 'list'])->name('layout_name_list');
            Route::match(['get', 'post'], '/add', [LayoutNameController::class, 'add'])->name('layout_name_add');
            Route::match(['get', 'post'], '/edit/{id}', [LayoutNameController::class, 'edit'])->name('layout_name_edit');
            Route::post('/delete', [LayoutNameController::class, 'delete'])->name('layout_name_delete');
        });


        // Fetch subcategories by category
        Route::get('get-subcategories/{category_id}', [EssentialController::class, 'getSubcategories']);

        // Fetch products by subcategory
        Route::get('get-products/{subcategory_id}', [EssentialController::class, 'getProducts']);

        
    },
);
Route::prefix('admin')->name('admin.')->group(function () {
    Route::resource('events', EventController::class);
});
Route::get('admin/get-cities/{state}', [TaskController::class, 'getCities']);
Route::get('admin/get-users/{state}/{city}', [TaskController::class, 'getUsers']);


Auth::routes();

Route::get('image-download/{image}', [HomeController::class, 'downloadImage'])->name('download.image');

Route::get('/home', [App\Http\Controllers\HomeController::class, 'index'])->name('home');
Route::get('/qrcode', [App\Http\Controllers\HomeController::class, 'list']);



// notification
Route::any('/store-token', [WebNotificationController::class, 'storeToken'])->name('store.token');
Route::any('/send-web-notification', [WebNotificationController::class, 'sendWebNotification'])->name('send.web-notification');
// notification


Route::post('/save-token', [App\Http\Controllers\Admin\HomeController::class, 'saveToken'])->name('save-token');
Route::post('/send-notification', [App\Http\Controllers\Admin\HomeController::class, 'sendNotification'])->name('send.notification');
