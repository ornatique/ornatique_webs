<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Offer;
use Illuminate\Http\Request;

class OfferController extends Controller
{
    public function list()
    {
        $data['data'] = Offer::all();
        return view('admin.offer.offer_list', $data);
    }

    public function add(Request $request)
    {
        if ($request->isMethod('post')) {
            $request->validate([
                'name' => 'required|string|max:255',
                'color' => 'required|string|max:7|regex:/^#([a-f0-9]{6})$/i', // Validation for hex color
            ]);
            $data = new Offer();
            $data->name = $request->name;
            $data->color = $request->color;
            $data->save();
            return redirect('admin/offer/list')->with('msg', 'Offer Added..!!!');
        }
        return view('admin.offer.offer_add');
    }

    public function edit(Request $request, $id)
    {
        if ($request->isMethod('post')) {
            $request->validate([
                'name' => 'required|string|max:255',
                'color' => 'required|string|max:7|regex:/^#([a-f0-9]{6})$/i', // Validation for hex color
            ]);
            $data = Offer::find($id);
            $data->name = $request->name;
            $data->color = $request->color;
            $data->save();
            return redirect('admin/offer/list')->with('msg', 'Offer Updated..!!!');
        }
        $data['data'] = Offer::find($id);
        return view('admin.offer.offer_edit', $data);
    }

    public function delete(Request $request)
    {
        if ($request->isMethod('post')) {
            $data = Offer::find($request->id);
            if ($data) {
                $data->delete();
                return redirect(route('admin_offer_list'))->with('msg', 'Offer Deleted..!!');
            }
        }
    }
}
