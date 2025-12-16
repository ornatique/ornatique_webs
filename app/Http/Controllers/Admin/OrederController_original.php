<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\User;
use App\Models\Product;
use App\Models\Order;
use Illuminate\Support\Facades\DB;

class OrederController extends Controller
{
    public function list(Request $request)
    {
        $data['data'] = Order::orderBy('created_at', 'DESC')
            ->whereNotNull('order_id')
            ->groupBy('order_id')
            ->select('orders.*', DB::raw('sum(weight)as weight'), DB::raw('sum(quantity)as quantity'))
            ->get();
        // return $data;
        return view('admin.order.order_list', $data);
    }



    public function edit(Request $request, $id)
    {
        $data = Order::find($id);
        $data->weight = $request->weight;
        $data->quantity = $request->quantity;
        $data->remarks = $request->remarks;
        $data->status = $request->status;
        $data->save();
        return redirect()->route('admin_order_list')->with('msg', 'Order Updated');
        $data['data'] = Order::find($id);
        return view('admin.order.order_edit', $data);
    }

    public function delete(request $request)
    {
        if ($_POST) {
            $data = Order::find($request->id);
            if ($data) {
                $data->delete();
                return response()->json(['msg' => 'Order Deleted Successfully..!!']);
            } else {
                return response()->json(['msg' => 'Order Already Deleted. Reload to see..!!']);
            }
            // Product::where('id', $request->id)->delete();
            return Redirect()
                ->back()
                ->with('msg', 'Order Deleted Successfully..!!');
        }
    }
}