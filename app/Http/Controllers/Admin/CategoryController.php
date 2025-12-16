<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Category;
use App\Models\User;
use App\Models\Permission;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Log;
use App\Helpers\FCMHelper;
use App\Helpers\FCMManualHelper;

class CategoryController extends Controller
{
    public function list()
    {
        // $permission = Permission::where('user_id', Auth::id())->get('category_id')->toArray();

        // $data['data'] = Category::orderBy('order', 'ASC')->get();
        $data['data'] = Category::orderByRaw('-priority DESC')->get();
        return view('admin.category.category_list', $data);
    }



    // public function add(Request $request)
    // {
    //     if ($_POST) {
    //         $request->validate([
    //             'name' => 'required|string|max:255',
    //             'image' => 'mimes:jpg,jpeg,png|required|max:2048',
    //             'priority' => 'required'
    //         ]);
    //         $data = new Category;
    //         $data->name = $request->name;
    //         $data->priority = $request->priority;
    //         if ($request->user_id) {
    //             $data->user_id = json_encode($request->user_id);
    //         }

    //         if ($request->image) {
    //             $thumb = $request->file('image');
    //             $thumb_file = $this->uploadImage($thumb, '');
    //             $data->image = $thumb_file;
    //         }
    //         if ($request->has('home') && $request->home == '1') {
    //             $data->home = '1';
    //         } else {
    //             $data->home = '0'; // Or leave it as is, depending on your use case
    //         }
    //         // return $data;
    //         $data->save();
    //         // $firebaseTokens = User::where('device_token', '!=', '')->get();
    //         $firebaseTokens = User::where('token', '!=', '')->get();


    //         $SERVER_API_KEY = 'AIzaSyCP7mwUzMGIESPbX30V5_sg8Ad0qqqwXtA';
    //         foreach ($firebaseTokens  as $firebaseToken) {
    //             $data = [
    //                 // "registration_ids" => $firebaseToken->device_token,
    //                 'to' => $firebaseToken->token,

    //                 "notification" => [
    //                     "title" => 'Ornatique',
    //                     "body" => 'Dummy Category Added by Ornatique',
    //                 ]
    //             ];
    //             $dataString = json_encode($data);

    //             $headers = [
    //                 'Authorization: key=' . $SERVER_API_KEY,
    //                 'Content-Type: application/json',
    //             ];

    //             $ch = curl_init();

    //             curl_setopt($ch, CURLOPT_URL, 'https://fcm.googleapis.com/fcm/send');
    //             curl_setopt($ch, CURLOPT_POST, true);
    //             curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
    //             curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);
    //             curl_setopt($ch, CURLOPT_HTTPHEADER, $headers);
    //             curl_setopt($ch, CURLOPT_POSTFIELDS, $dataString);

    //             $response = curl_exec($ch);
    //             if ($response === false) {
    //                 \Log::error('FCM Send Error: ' . curl_error($ch));
    //             } else {
    //                 \Log::info('FCM Response: ' . $response);
    //             }
    //             curl_close($ch);
    //         }
    //         \Log::info('Firebase loop completed');

    //         return redirect()->route('admin_categoty_list')->with('msg', 'Category Added Successfully.');
    //     }
    //     $data['users'] = User::where('admin', '0')->get();
    //     return  view('admin.category.category_add', $data);
    // }



    public function add(Request $request)
    {
        if ($request->isMethod('post')) {
            $request->validate([
                'name' => 'required|string|max:255',
                'image' => 'mimes:jpg,jpeg,png,gif|max:2048',
                'priority' => 'required',
                'shape' => 'nullable|string|max:50',
            ]);

            $data = new Category;
            $data->name = $request->name;
            $data->priority = $request->priority;
            $data->color = $request->color;
            $data->shape = $request->shape;

            if ($request->user_id) {
                $data->user_id = json_encode($request->user_id);
            }

            if ($request->hasFile('image')) {
                $thumb = $request->file('image');
                $thumb_file = $this->uploadImage($thumb, '');
                $data->image = $thumb_file;
            }

            $data->home = $request->home == '1' ? '1' : '0';
            $data->save();

            // ✅ FCM push using your desired function call
            $firebaseUsers = User::whereNotNull('token')->where('token', '!=', '')->get();

            foreach ($firebaseUsers as $user) {
                FCMManualHelper::sendPush($user->token, 'Ornatique', 'Category Added by Ornatique');
            }

            \Log::info('All manual FCM push notifications sent successfully.');

            return redirect()->route('admin_category_list')->with('msg', 'Category Added Successfully.');
        }

        $data['users'] = User::where('admin', '0')->get();
        return view('admin.category.category_add', $data);
    }


    public function edit(Request $request, $id)
    {

        // return $request;

        if ($_POST) {
            $request->validate([
                'name' => 'required|string|max:255',
                'image' => 'mimes:jpg,jpeg,png,gif|max:2048',
                'priority' => 'required',
                // 'user_id' => 'required'
                'shape' => 'nullable|string|max:50',
            ]);
            $data = Category::find($id);
            $data->priority = $request->priority;
            $data->name = $request->name;
            $data->user_id = $request->user_id;
            $data->color = $request->color;
            $data->shape = $request->shape;

            if ($request->image) {
                $thumb = $request->file('image');
                $thumb_file = $this->uploadImage($thumb, '');
                $data->image = $thumb_file;
            }
            if ($request->has('home') && $request->home == '1') {
                $data->home = '1';
            } else {
                $data->home = '0'; // Or leave it as is, depending on your use case
            }
            $data->save();
            // return $data;
            return redirect()->route('admin_category_list')->with('msg', 'Category Edited Successfully.');
        }
        $data['users'] = User::where('admin', '0')->get();
        $data['data'] = Category::find($id);
        return  view('admin.category.category_edit', $data);
    }

    public function uploadImage($file, $dir)
    {
        $extension = $file->getClientOriginalExtension();
        $name = str_replace(' ', '-', $file->getClientOriginalName());
        $filename =  $name;
        $file->move("public/assets/images/categories/", $filename);
        return $filename;
    }

    public function delete(Request $request)
    {
        if ($_POST) {
            $data = Category::find($request->id);
            if ($data) {
                $data->delete();
                return response()->json(['msg' => 'Category Deleted Successfully..!!']);
            } else {
                return response()->json(['msg' => 'Category Already Deleted. Reload to see..!!']);
            }
            // Category::where('id', $request->id)->delete();
            return Redirect()->back()->with('msg', 'Category Deleted Successfully..!!');
        }
        return Redirect()->back();
    }
}