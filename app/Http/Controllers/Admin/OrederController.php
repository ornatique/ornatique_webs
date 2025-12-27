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
    // public function list(Request $request)
    // {
    //     // $data['data'] = Order::orderBy('created_at', 'DESC')
    //     //     ->whereNotNull('order_id')
    //     //     ->groupBy('order_id')
    //     //     ->select('orders.*', DB::raw('sum(weight)as weight'), DB::raw('sum(quantity)as quantity'), DB::raw('CAST(weight * quantity AS DECIMAL(10,3))as total'))
    //     //     ->get();
    //     $data['data'] = Order::with('product')
    //         ->groupBy('order_id')
    //         ->orderBy('created_at', 'ASC')
    //         // ->select('*', DB::raw('CAST(SUM(weight) AS DECIMAL(10,3))as total'))
    //         // ->select('*', DB::raw('CAST(weight * quantity AS DECIMAL(10,3))as total'), 'sum(total) as sum')
    //         ->selectRaw('*, CAST(sum(weight * quantity) as DECIMAL(10,3)) as total, sum(quantity) as total_qun')
    //         // ->selectRaw('*, sum(weight * quantity) as sum')
    //         ->get();
    //     // return $data['data'];
    //     return view('admin.order.order_list', $data);
    // }


    public function list(Request $request)
    {
       $data['data'] = Order::join('users', 'users.id', '=', 'orders.user_id')
    ->select(
        'orders.order_id',
        DB::raw('MAX(users.name) AS user_name'),
        DB::raw('MAX(users.id) AS user_id'),
        DB::raw('MAX(orders.status) AS status'),
        DB::raw('CAST(SUM(orders.weight * orders.quantity) AS DECIMAL(10,3)) AS total'),
        DB::raw('SUM(orders.quantity) AS total_qun'),
        DB::raw('MAX(orders.remarks) AS remarks'),
        DB::raw('MAX(orders.created_at) AS created_at')
    )
        ->groupBy('orders.order_id')
        ->orderBy('created_at', 'ASC')
        ->get();

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
            $data = Order::where('order_id', $request->id)->delete();
            return response()->json(['msg' => 'Order Deleted Successfully..!!']);
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
