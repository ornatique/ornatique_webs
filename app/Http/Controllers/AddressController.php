<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Address;

class AddressController extends Controller
{
    //

    public function index(request $request)
    {
        if ($_POST) {
            $request->validate([
                'name' => 'required|string|min:2|max:255',
                // 'last_name' => 'required|string|min:2|max:255',
                'state' => 'required|string|min:2|max:255',
                'area' => 'required|string|min:2|max:255',
                'city' => 'required|string|min:2|max:255',
                'pincode' => 'required|numeric|min:2',
                'contact' => 'required|numeric|digits:10',
                'address' => 'required|string|min:3',
            ]);
            $data = new Address;
            $data->name = $request->name;
            if ($request->last_name) {
                $data->last_name = $request->last_name;
            }
            $data->state = $request->state;
            $data->area = $request->area;
            $data->city = $request->city;
            $data->pincode = $request->pincode;
            $data->contact = $request->contact;
            $data->address = $request->address;
            $data->save();
        }
        return view('frontend.address.address');
    }

    public function edit(Request $request, $id)
    {
        if ($_POST) {
            $request->validate([
                'name' => 'required|string|min:2|max:255',
                // 'last_name' => 'required|string|min:2|max:255',
                'state' => 'required|string|min:2|max:255',
                'area' => 'required|string|min:2|max:255',
                'city' => 'required|string|min:2|max:255',
                'pincode' => 'required|numeric|min:2',
                'contact' => 'required|numeric|digits:10',
                'address' => 'required|string|min:3',
            ]);
            $data = Address::find($id);
            $data->name = $request->name;
            if ($request->last_name) {
                $data->last_name = $request->last_name;
            }
            $data->state = $request->state;
            $data->area = $request->area;
            $data->city = $request->city;
            $data->pincode = $request->pincode;
            $data->contact = $request->contact;
            $data->address = $request->address;
            $data->save();
        }
        $data['data'] = Address::find($id);
        return view('frontend.address.address_edit', $data);
    }
}
