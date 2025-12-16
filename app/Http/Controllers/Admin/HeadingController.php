<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Heading;
use Illuminate\Http\Request;

class HeadingController extends Controller
{
    public function index()
    {
        $data['data'] = Heading::all();
        return view('admin.heading.list', $data);
    }

    public function add(Request $request)
    {
        if ($request->isMethod('post')) {
            $request->validate([
                'heading_one' => 'required|string|min:2|max:255',
                'heading_two' => 'required|string|min:2|max:255',
                'heading_three' => 'required|string|min:2|max:255',
            ]);

            $data = new Heading();
            $data->heading_one = $request->heading_one;
            $data->heading_two = $request->heading_two;
            $data->heading_three = $request->heading_three;
            $data->app_bar_color = $request->app_bar_color;
            $data->bottom_bar_color = $request->bottom_bar_color;
            $data->back_ground_color = $request->back_ground_color;
            $data->save();
            return redirect()->route('admin_heading_list')->with('msg', 'Heading Added Successfully.');
        }

        return view('admin.heading.add');
    }


    public function edit(Request $request, $id)
    {
        if ($_POST) {
            $request->validate([
                'heading_one' => 'required|string|min:2|max:255',
                'heading_two' => 'required|string|min:2|max:255',
                'heading_three' => 'required|string|min:2|max:255',
            ]);
            $data = Heading::find($id);
            $data->heading_one = $request->heading_one;
            $data->heading_two = $request->heading_two;
            $data->heading_three = $request->heading_three;
            $data->app_bar_color = $request->app_bar_color;
            $data->bottom_bar_color = $request->bottom_bar_color;
            $data->back_ground_color = $request->back_ground_color;

            $data->save();
            return redirect()->route('admin_heading_list')->with('msg', 'Heading Edited Successfully.');
        }
        $data['data'] = Heading::find($id);
        return  view('admin.heading.edit', $data);
    }



    public function delete(Request $request)
    {
        if ($_POST) {
            $data = Heading::find($request->id);
            if ($data) {
                $data->delete();
                return response()->json(['msg' => 'Heading Deleted Successfully..!!']);
            } else {
                return response()->json(['msg' => 'Heading Already Deleted. Reload to see..!!']);
            }
            // Category::where('id', $request->id)->delete();
            return Redirect()->back()->with('msg', 'Heading Deleted Successfully..!!');
        }
        return Redirect()->back();
    }
}
