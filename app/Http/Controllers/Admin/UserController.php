<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Category;
use Illuminate\Http\Request;
use App\Models\User;
use App\Models\User_access;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Http;

use App\Models\User_role;
// if (auth()->check() && auth()->user()->type == 'admin')

use Illuminate\Support\Facades\Redirect;

class UserController extends Controller
{
    public function list(Request $request)
    { {

            $data['data'] = User::where('admin', '1')->get();
            return view('admin.user.user_list', $data);
        }
    }

    // public function add(Request $request)
    // {
    //     if ($request->isMethod('post')) {
    //         $request->validate([
    //             'name' => 'required|string|min:2|max:255',
    //             'city' => 'required|string|min:2|max:255',
    //             'image' => 'image|mimes:jpeg,png,jpg,gif,svg|max:2048',
    //             'email' => 'required|string|min:2|max:255|unique:users',
    //             'number' => 'required|digits:10|unique:users',
    //             'password' => 'required|string|min:5|confirmed',
    //         ]);

    //         $data = new User();
    //         $data->name = $request->name;
    //         $data->city = $request->city;
    //         $data->email = $request->email;
    //         $data->status = '1';
    //         $data->number = $request->number;
    //         if ($request->password) {
    //             $data->password = Hash::make($request->password);
    //         }
    //         if ($request->image) {
    //             $thumb = $request->file('image');
    //             $thumb_file = $this->uploadImage($thumb, '');
    //             $data->image = $thumb_file;
    //         }

    //         // Set admin only if checkbox is visible (passed 'type' param) and checked
    //         if ($request->has('admin') && $request->admin == '1') {
    //             $data->admin = '1';
    //         } else {
    //             $data->admin = '0';
    //         }

    //         $data->save();

    //         $user = User::orderBy('id', 'DESC')->first();
    //         $data  = new User_access;
    //         $data->user_id = $user->id;
    //         $data->save();

    //         return redirect()->route('admin_home')->with('msg', 'User Added Successfully...!!!');
    //     }

    //     $type = $request->query('type', null);

    //     // Fetch Gujarat cities
    //     $gujaratResponse = Http::post('https://countriesnow.space/api/v0.1/countries/state/cities', [
    //         'country' => 'India',
    //         'state' => 'Gujarat'
    //     ]);

    //     $maharashtraResponse = Http::post('https://countriesnow.space/api/v0.1/countries/state/cities', [
    //         'country' => 'India',
    //         'state' => 'Maharashtra'
    //     ]);

    //     $gujaratCities = $gujaratResponse->successful() ? $gujaratResponse->json()['data'] : [];
    //     $maharashtraCities = $maharashtraResponse->successful() ? $maharashtraResponse->json()['data'] : [];

    //     // Merge and remove duplicates just in case
    //     $cities = array_unique(array_merge($gujaratCities, $maharashtraCities));
    //     sort($cities); // Optional: sort alphabetically

    //     return view('admin.user.user_add', [
    //         'isAdminRoute' => $type === 'admin',
    //         'cities' => $cities,
    //     ]);
    // }


    public function add(Request $request)
    {
         $type = $request->input('type');
        if ($request->isMethod('post')) {
            $request->validate([
                'name' => 'required|string|min:2|max:255',
                'state' => 'required|string|min:2|max:255',
                'city' => 'required|string|min:2|max:255',
                'image' => 'image|mimes:jpeg,png,jpg,gif,svg|max:2048',
                'email' => 'required|string|min:2|max:255|unique:users',
                'number' => 'required|digits:10|unique:users',
                'password' => 'required|string|min:5|confirmed',
            ]);

            $data = new User();
            $data->name = $request->name;
            $data->state = $request->state;
            $data->city = $request->city;
            $data->email = $request->email;
            $data->status = '1';
            $data->number = $request->number;

            if ($request->password) {
                $data->password = Hash::make($request->password);
            }

            if ($request->image) {
                $thumb = $request->file('image');
                $thumb_file = $this->uploadImage($thumb, '');
                $data->image = $thumb_file;
            }

            if ($request->has('admin') && $request->admin == '1') {
                $data->admin = '1';
            } else {
                $data->admin = '0';
            }
            $data->category_ids = json_encode($request->categories);
            $data->save();

            $user = User::orderBy('id', 'DESC')->first();
            $data  = new User_access;
            $data->user_id = $user->id;
            $data->save();

             if($type == "customer"){
                  return redirect('/admin/custumer/list')->with('msg', 'Customer Add Successfully...!!!');
            }else{
                 return redirect()->route('admin_user_list')->with('msg', 'User Add Successfully...!!!');
            }
        }

        $type = $request->query('type', null);

        // Fetch Indian states
        $states = $this->getIndianStates();
        $categories = Category::all();

        return view('admin.user.user_add', [
            'isAdminRoute' => $type === 'admin',
            'states' => $states,
            'categories' => $categories,
            'cities' => [] // Empty initially, will be populated via AJAX
        ]);
    }

    // Add these helper methods to your controller
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

    // Add this API endpoint to your controller
    public function getCities(Request $request)
    {
        $request->validate([
            'state' => 'required|string'
        ]);

        try {
            $response = Http::post('https://countriesnow.space/api/v0.1/countries/state/cities', [
                'country' => 'India',
                'state' => $request->state
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




    // public function edit(Request $request, $id)
    // {
    //     if ($request->isMethod('post')) {
    //         $request->validate([
    //             'name' => 'required|string|min:2|max:255',
    //             'email' => 'required|string|max:255|unique:users,email,' . $id,
    //             'number' => 'required|digits:10|unique:users,number,' . $id,
    //         ]);

    //         $data = User::find($id);
    //         $data->name = $request->name;
    //         $data->email = $request->email;
    //         $data->number = $request->number;
    //         $data->city = $request->city;

    //         if ($request->password) {
    //             $data->password = Hash::make($request->password);
    //         }

    //         if ($request->image) {
    //             $thumb = $request->file('image');
    //             $thumb_file = $this->uploadImage($thumb, '');
    //             $data->image = $thumb_file;
    //         }

    //         $data->admin = $request->has('admin') && $request->admin == '1' ? '1' : '0';

    //         $data->save();
    //         return redirect()->route('admin_user_list')->with('msg', 'User Updated Successfully...!!!');
    //     }

    //     $user = User::find($id);
    //     $type = $request->query('type', null);

    //     // ✅ Fetch cities from Gujarat and Maharashtra
    //     $gujaratResponse = Http::post('https://countriesnow.space/api/v0.1/countries/state/cities', [
    //         'country' => 'India',
    //         'state' => 'Gujarat'
    //     ]);

    //     $maharashtraResponse = Http::post('https://countriesnow.space/api/v0.1/countries/state/cities', [
    //         'country' => 'India',
    //         'state' => 'Maharashtra'
    //     ]);

    //     $gujaratCities = $gujaratResponse->successful() ? $gujaratResponse->json()['data'] : [];
    //     $maharashtraCities = $maharashtraResponse->successful() ? $maharashtraResponse->json()['data'] : [];

    //     $cities = array_unique(array_merge($gujaratCities, $maharashtraCities));
    //     sort($cities);

    //     return view('admin.user.user_edit', [
    //         'data' => $user,
    //         'isAdminRoute' => $type === 'admin',
    //         'cities' => $cities,
    //     ]);
    // }

    public function edit(Request $request, $id)
    {
        
        if ($request->isMethod('post')) {
            $request->validate([
                'name' => 'required|string|min:2|max:255',
                'state' => 'required|string|min:2|max:255', // Add state validation
                'city' => 'required|string|min:2|max:255',
                'email' => 'required|string|max:255|unique:users,email,' . $id,
                'number' => 'required|digits:10|unique:users,number,' . $id,
            ]);
            // dd($request);
            $data = User::find($id);
            $data->name = $request->name;
            $data->state = $request->state; // Add state
            $data->city = $request->city;
            $data->email = $request->email;
            $data->number = $request->number;

            if ($request->password) {
                $data->password = Hash::make($request->password);
            }

            if ($request->image) {
                $thumb = $request->file('image');
                $thumb_file = $this->uploadImage($thumb, '');
                $data->image = $thumb_file;
            }

            $data->admin = $request->has('admin') && $request->admin == '1' ? '1' : '0';
            $data->category_ids = json_encode($request->categories);

            $data->save();
            $type = $request->input('type');
            if($type == "customer"){
                  return redirect('/admin/custumer/list')->with('msg', 'Customer Updated Successfully...!!!');
            }else{
                 return redirect()->route('admin_user_list')->with('msg', 'User Updated Successfully...!!!');
            }
        }

        $user = User::find($id);
        $type = $request->query('type', null);

        // Fetch Indian states
        $states = $this->getIndianStates();

        // Fetch cities for the user's current state if available
        $cities = [];
        if ($user->state) {
            $cities = $this->getCitiesForState($user->state);
        }
        $categories = Category::all();

        $selectedCategories = $user->category_ids
            ? json_decode($user->category_ids, true)
            : [];


        return view('admin.user.user_edit', [
            'data' => $user,
            'isAdminRoute' => $type === 'admin',
            'states' => $states,
            'cities' => $cities,
            'categories' => $categories,
            'selectedCategories' => $selectedCategories,
        ]);
    }



    private function getCitiesForState($state)
    {
        try {
            $response = Http::post('https://countriesnow.space/api/v0.1/countries/state/cities', [
                'country' => 'India',
                'state' => $state
            ]);

            if ($response->successful()) {
                $cities = $response->json()['data'];
                sort($cities);
                return $cities;
            }
        } catch (\Exception $e) {
            // Log::error('Failed to fetch cities for state ' . $state . ': ' . $e->getMessage());
        }

        return [];
    }

    // Keep the existing getCities API endpoint for AJAX




    public function delete(Request $request)
    {
        if ($_POST) {
            $data = User::find($request->id);
            if ($data) {
                $data->delete();
                return response()->json(['msg' => 'User Deleted Successfully..!!']);
            } else {
                return response()->json(['msg' => 'User Already Deleted. Reload to see..!!']);
            }
            // User::where('id', $request->id)->delete();
            return response()->json(['msg' => 'User Deleted Successfully..!!']);
            return Redirect()->back()->with('msg', 'User Deleted Successfullyy...!!');
        }
    }

    public function uploadImage($file, $dir)
    {
        $extension = $file->getClientOriginalExtension();
        $name = str_replace(' ', '-', $file->getClientOriginalName());
        $filename = $name;
        $file->move('public/assets/images/users/', $filename);
        return $filename;
    }

    public function index(Request $request)
    {
        $data['data'] = User_access::join('users', function ($join) {
            $join->on('user_accesses.user_id', '=', 'users.id')
                ->where('users.admin', '1');
        })->get();
        return view('admin.user.role_list', $data);
    }

    public function user_role(Request $request)
    {
        
        $field = $request->model;
        // $data = User_access::find($request->id);
        $data = User_access::where('user_id', $request->id)->first();

        $data->$field  = $request->status;
        
        $data->save();
        return;
    }
}
