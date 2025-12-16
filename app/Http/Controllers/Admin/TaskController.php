<?php

namespace App\Http\Controllers\Admin;

use App\Helpers\FCMManualHelper;
use App\Http\Controllers\Controller;
use App\Jobs\SendTaskNotificationJob;
use App\Models\Category;
use App\Models\Subcategory;
use App\Models\Task;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Http;

class TaskController extends Controller
{
    public function index()
    {
        $data['data'] = Task::all();
        return view('admin.task', $data);
    }



    // public function add(Request $request)
    // {
    //     if ($request->isMethod('post')) {
    //         $request->validate([
    //             'title' => 'required|string|max:255',
    //             'description' => 'required|string',
    //             'image' => 'mimes:jpg,jpeg,png|required|max:2048',
    //         ]);

    //         $data = new Task();
    //         $data->title = $request->title;
    //         $data->description = $request->description;


    //         if ($request->hasFile('image')) {
    //             $thumb = $request->file('image');
    //             $thumb_file = $this->uploadImage($thumb, '');
    //             $data->image = $thumb_file;
    //         }


    //         $data->save();

    //         // ✅ FCM push using your desired function call
    //         $firebaseUsers = User::whereNotNull('token')->where('token', '!=', '')->get();

    //         foreach ($firebaseUsers as $user) {
    //             FCMManualHelper::sendPush($user->token, 'Ornatique', 'Category Added by Ornatique');
    //         }

    //         \Log::info('All manual FCM push notifications sent successfully.');

    //         return redirect('admin/custom/notificaion')->with('msg', 'Custom Notification Send..!!');
    //     }

    //     $data['users'] = User::where('admin', '0')->get();
    //     return view('admin.task_add', $data);
    // }


    // public function add(Request $request)
    // {
    //     if ($request->isMethod('post')) {
    //         $request->validate([
    //             'title' => 'required|string|max:255',
    //             'description' => 'required|string',
    //             'image' => 'mimes:jpg,jpeg,png|required|max:2048',
    //         ]);

    //         $data = new Task();
    //         $data->title = $request->title;
    //         $data->description = $request->description;
    //         $data->category_id = $request->category_id;
    //         $data->subcategory_id = $request->sub_category;
    //         $data->product_id = $request->product_id;

    //         $imageUrl = null;

    //         if ($request->hasFile('image')) {
    //             $thumb = $request->file('image');
    //             $thumb_file = $this->uploadImage($thumb, '');
    //             $data->image = $thumb_file;

    //             $imageUrl = asset('public/assets/images/notification/' . $thumb_file); // ✅ Full public image URL for push
    //         }
    //         // return $data;
    //         $data->save();

    //         // 🔔 Send push with dynamic title, description, and image
    //         $firebaseUsers = User::whereNotNull('token')->where('token', '!=', '')->get();


    //         if ($request->has('users') && count($request->users) > 0) {
    //             // Only selected users
    //             $firebaseUsers = User::whereIn('id', $request->users)
    //                 ->whereNotNull('token')
    //                 ->where('token', '!=', '')
    //                 ->get();
    //         } else {
    //             // Default: all users
    //             $firebaseUsers = User::whereNotNull('token')
    //                 ->where('token', '!=', '')
    //                 ->get();
    //         }


    //         $categoryName = optional($data->category)->name;
    //         $subcategoryName = optional($data->subcategory)->name;

    //         $pushTitle = $data->title;
    //         $pushBody = $data->description . ' (' . ucwords($categoryName) . ' / ' . ucwords($subcategoryName) . ')';

    //         foreach ($firebaseUsers as $user) {
    //             FCMManualHelper::sendPushWithImage(
    //                 $user->token,
    //                 $pushTitle,
    //                 $pushBody,
    //                 $imageUrl,
    //                 $data->category_id,
    //                 $data->subcategory_id,
    //                 $data->product_id
    //             );
    //         }


    //         \Log::info('Dynamic content FCM push notifications sent.');

    //         return redirect('admin/custom/notificaion')->with('msg', 'Custom Notification Sent..!!');
    //     }

    //     $data['users'] = User::where('admin', '0')->get();
    //     $data['categories'] = Category::all();
    //     $data['sub_categories'] = Subcategory::all();
    //     return view('admin.task_add', $data);
    // }


    public function add(Request $request)
    {
        if ($request->isMethod('post')) {
            $request->validate([
                'title' => 'required|string|max:255',
                'description' => 'required|string',
                'image' => 'mimes:jpg,jpeg,png|required|max:2048',
                'state' => 'nullable|string',
                'city' => 'nullable|string',
                'users' => 'nullable|array',
            ]);

            $task = new Task();
            $task->title = $request->title;
            $task->description = $request->description;
            $task->category_id = $request->category_id;
            $task->subcategory_id = $request->sub_category;
            $task->product_id = $request->product_id;
            // $task->user_id = implode(',', $request->users); // store selected users as CSV
            $task->user_id = $request->filled('users')
                ? implode(',', (array) $request->users)
                : null;

            if ($request->hasFile('image')) {
                $thumb_file = $this->uploadImage($request->file('image'), '');
                $task->image = $thumb_file;
                $imageUrl = asset('public/assets/images/notification/' . $thumb_file);
            } else {
                $imageUrl = null;
            }

            $task->save();

            // Send FCM only to selected users
            // $firebaseUsers = User::whereIn('id', $request->users)
            //     ->whereNotNull('token')
            //     ->where('token', '!=', '')
            //     ->get();
            // Determine which users to send notification to
            if ($request->has('users') && count($request->users) > 0) {
                $firebaseUsers = User::whereIn('id', $request->users)
                    ->whereNotNull('token')
                    ->where('token', '!=', '')
                    ->get();
            } else {
                // All users in the selected state + city
                $firebaseUsers = User::where('state', $request->state)
                    ->where('city', $request->city)
                    ->whereNotNull('token')
                    ->where('token', '!=', '')
                    ->get();
            }

            $pushTitle = $task->title;
            $pushBody = $task->description;

            foreach ($firebaseUsers as $user) {
                FCMManualHelper::sendPushWithImage(
                    $user->token,
                    $pushTitle,
                    $pushBody,
                    $imageUrl,
                    $task->category_id,
                    $task->subcategory_id,
                    $task->product_id
                );
            }

            return redirect('admin/custom/notificaion')->with('msg', 'Custom Notification Sent..!!');
        }

        // GET
        $states = $this->getIndianStates();
        $categories = Category::all();
        $sub_categories = Subcategory::all();

        return view('admin.task_add', compact('states', 'categories', 'sub_categories'));
    }


    private function getIndianStates()
    {
        try {
            $response = Http::post('https://countriesnow.space/api/v0.1/countries/states', [
                'country' => 'India'
            ]);

            if ($response->successful()) {
                return collect($response->json()['data']['states'])->pluck('name')->sort()->toArray();
            }
        } catch (\Exception $e) {
            Log::error('Failed to fetch states: ' . $e->getMessage());
        }

        return [];
    }

    // Add a method to get cities for AJAX
    public function getCities($state)
    {
        try {
            $response = Http::post('https://countriesnow.space/api/v0.1/countries/state/cities', [
                'country' => 'India',
                'state' => $state
            ]);

            if ($response->successful()) {
                $cities = $response->json()['data'];
                sort($cities);
                return response()->json($cities);
            }
        } catch (\Exception $e) {
            Log::error('Failed to fetch cities: ' . $e->getMessage());
        }

        return response()->json([], 400);
    }

    // Add a method to get users by state + city for AJAX
    public function getUsers($state, $city)
    {
        $users = User::where('state', $state)
            ->where('city', $city)
            ->where('admin', '0')
            ->get(['id', 'name', 'email']);
        return response()->json($users);
    }




    public function edit(Request $request, $id)
    {
        $data = Task::findOrFail($id);

        if ($request->isMethod('post')) {
            $request->validate([
                'title' => 'required|string|max:255',
                'description' => 'required|string',
                'image' => 'nullable|mimes:jpg,jpeg,png|max:2048',
            ]);

            $data->title = $request->title;
            $data->description = $request->description;
            $data->category_id = $request->category_id;
            $data->subcategory_id = $request->subcategory_id;
            $data->product_id = $request->product_id;
            $imageUrl = null;

            if ($request->hasFile('image')) {
                // Delete old image if exists
                if (!empty($data->image) && file_exists(public_path('assets/images/notification/' . $data->image))) {
                    unlink(public_path('assets/images/notification/' . $data->image));
                }

                $thumb = $request->file('image');
                $thumb_file = $this->uploadImage($thumb, '');
                $data->image = $thumb_file;

                $imageUrl = asset('public/assets/images/notification/' . $thumb_file);
            } else {
                $imageUrl = asset('public/assets/images/notification/' . $data->image);
            }

            $data->user_id = $request->filled('users')
                ? implode(',', $request->users)
                : null;

            // $data->state = $request->state;
            // $data->city = $request->city;


            $data->save();

            // 🔔 Push updated content to all users
            // 🔔 Push updated content (same logic as ADD)
            if ($request->filled('users')) {
                $firebaseUsers = User::whereIn('id', $request->users)
                    ->whereNotNull('token')
                    ->where('token', '!=', '')
                    ->get();
                // } else {
                //     $firebaseUsers = User::where('state', $request->state)
                //         ->where('city', $request->city)
                //         ->whereNotNull('token')
                //         ->where('token', '!=', '')
                //         ->get();
                // } //only state city wise user will get
            } else {
                $firebaseUsers = User::whereNotNull('token')
                    ->where('token', '!=', '')
                    ->get();
            }


            $categoryName = optional($data->category)->name;
            $subcategoryName = optional($data->subcategory)->name;

            $pushTitle = $data->title;
            $pushBody = $data->description . ' (' . ucwords($categoryName) . ' / ' . ucwords($subcategoryName) . ')';

            foreach ($firebaseUsers as $user) {
                FCMManualHelper::sendPushWithImage(
                    $user->token,
                    $pushTitle,
                    $pushBody,
                    $imageUrl,
                    $data->category_id,
                    $data->subcategory_id,
                    $data->product_id
                );
            }

            \Log::info('FCM push notifications sent after update.');

            return redirect('admin/custom/notificaion')->with('msg', 'Notification Updated and Sent..!!');
        }
        $dataList['states'] = $this->getIndianStates();

        // Preselected users array
        $dataList['selectedUsers'] = $data->user_id
            ? explode(',', $data->user_id)
            : [];

        // Pre-fill state & city (if task already has users)
        if (!empty($dataList['selectedUsers'])) {
            $firstUser = User::find($dataList['selectedUsers'][0]);
            $dataList['state'] = $firstUser->state ?? null;
            $dataList['city'] = $firstUser->city ?? null;

            $dataList['cityUsers'] = User::where('state', $dataList['state'])
                ->where('city', $dataList['city'])
                ->get();
        } else {
            $dataList['state'] = null;
            $dataList['city'] = null;
            $dataList['cityUsers'] = [];
        }


        $dataList['data'] = $data;
        $dataList['users'] = User::where('admin', '0')->get();
        $dataList['categories'] = Category::all();
        $dataList['sub_categories'] = Subcategory::all();
        // $data['sub_categories'] = Subcategory::where('category_id', $data['data']->category_id)->get();

        return view('admin.task_edit', $dataList);
    }


    public function uploadImage($file, $dir)
    {
        $extension = $file->getClientOriginalExtension();
        $name = str_replace(' ', '-', $file->getClientOriginalName());
        $filename =  $name;
        $file->move("public/assets/images/notification/", $filename);
        return $filename;
    }

    public function delete(Request $request)
    {
        $request->validate([
            'id' => 'required|exists:tasks,id',
        ]);

        $task = Task::findOrFail($request->id);

        // Delete image if exists
        // if (!empty($task->image) && file_exists(public_path('assets/images/notification/' . $task->image))) {
        //     unlink(public_path('assets/images/notification/' . $task->image));
        // }

        $task->delete();

        return redirect()->back()->with('msg', 'Notification deleted successfully.');
    }


    public function resend($id)
    {
        $task = Task::findOrFail($id);

        $imageUrl = $task->image ? asset('public/assets/images/notification/' . $task->image) : null;

        $firebaseUsers = User::whereNotNull('token')->where('token', '!=', '')->get();

        $categoryName = optional($task->category)->name;
        $subcategoryName = optional($task->subcategory)->name;

        $pushTitle = $task->title;
        $pushBody = $task->description . ' (' . ucwords($categoryName) . ' / ' . ucwords($subcategoryName) . ')';

        foreach ($firebaseUsers as $user) {
            FCMManualHelper::sendPushWithImage(
                $user->token,
                $pushTitle,
                $pushBody,
                $imageUrl
            );
        }

        // SendTaskNotificationJob::dispatch($task);



        // Log::info("Notification resent for Task ID: $id");

        return redirect()->back()->with('msg', 'Notification resent successfully!');
    }
}
