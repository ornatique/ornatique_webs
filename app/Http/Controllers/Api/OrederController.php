<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Order;
use App\Models\Product;
use App\Models\User;
use App\Models\Cart;
use App\Models\Save;
use App\Models\Notification;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;


class OrederController extends Controller
{
    public function order(Request $request)
    {

        $validatiion = Validator::make($request->all(), [
            'user_id' => 'required',
        ]);

        if ($validatiion->fails()) {
            return response()->json(['status' => '0',  'message' => 'Validation Error', 'error' => $validatiion->errors()->getMessages()], 400);
        } else {
            $data = Order::where('user_id', $request->user_id)->groupBy('order_id')->with('product')
                ->orderBy('updated_at', 'DESC')->get();
            if (count($data) > 0) {
                return response()->json(['status' => '1', 'message' => 'Ordered List', 'image_url' => asset('public/assets/images/product'), 'data' => $data], 200);
            } else {
                return response()->json(['status' => '0', 'message' => 'Empty Orders'], 400);
            }
        }
    }



    public function store(Request $request)
    {
        
        $validatiion = Validator::make($request->all(), [
            'user_id' => 'required',
        ]);

        if ($validatiion->fails()) {
            return response()->json(['status' => '0', 'message' => 'Validation Error', 'error' => $validatiion->errors()->getMessages()], 400);
        } else {
            $data = Cart::where('user_id', $request->user_id)->with('product')->orderBy('updated_at', 'DESC')->get();
            $user = User::find($request->user_id);
            $order_id = ucwords($user->name) . '-' . rand(0000, 9999);
            // dd($data);
            if (count($data) > 0) {
                foreach ($data as $key) {
                    $order = new Order();
                    $order->order_id = $order_id;
                    $order->product_id = $key->product_id;
                    $order->user_id = $key->user_id;
                    $order->quantity = $key->quantity;
                    if ($key->product) {
                        $order->weight = $key->product->weight??0;
                    }
                    $order->remarks = $request->remarks;
                    $order->save();
                   if ($key->product && $key->product->order_confirm == 0) {
                        $key->product->update([
                            'order_confirm' => '1'
                        ]);
                    }
                    $affected = Save::where('user_id', $key->user_id)
                        ->where('product_id', $key->product_id)
                        ->where('is_save', '1')
                        ->update(['is_save' => '0']);

                    // dd($affected);

                    $id = Order::select('id', 'order_id')->orderBy('id', 'DESC')->first();
                   
                }
                $data = new Notification;
                $data->user_id = $request->user_id;
                $data->notification_type = 'order';
                $data->product_id = $key->product_id;
                $data->order_id = $id->order_id;
                if ($key->product) {
                    $data->message = ' Order Placed';
                } else {
                    $data->message = 'Order Placed';
                }
                $data->save();

                $firebaseToken = User::find($request->user_id);
                // return $firebaseToken;
                if ($firebaseToken->device_token) {
                    $SERVER_API_KEY = 'fhiWIucATW25FFkQEvFHRB:APA91bEvnM_8XK7UIi4HOs542fsxAA_L7OIFwOwBtVE4fXFTa_lFYrWJ-TPyYV-msfDxmUKcWdURIZjAB7uA9wcuuy9rLhE5O58d00u4ZAkF60LPqHOQb7g';

                    $data = [
                        // "registration_ids" => $firebaseToken->device_token,
                        // 'to' => 'BPvdKB5sL7PMnBadBMwOWwLcUvCGsJXZ4CMFOINbA9MRvzaGr7U7uXIvyhs8igF_rk54_ipFoQyNoO6jDSHcMzw',
                        'to' => $firebaseToken->device_token,
                        "notification" => [
                            "title" => 'Custom Placed',
                            "body" => 'Estimate Placed Successfully',
                        ]
                    ];
                    $dataString = json_encode($data);

                    $headers = [
                        'Authorization: key=' . $SERVER_API_KEY,
                        'Content-Type: application/json',
                    ];

                    $ch = curl_init();

                    curl_setopt($ch, CURLOPT_URL, 'https://fcm.googleapis.com/fcm/send');
                    curl_setopt($ch, CURLOPT_POST, true);
                    curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
                    curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);
                    curl_setopt($ch, CURLOPT_HTTPHEADER, $headers);
                    curl_setopt($ch, CURLOPT_POSTFIELDS, $dataString);

                    $response = curl_exec($ch);
                    // $data = new Notification;
                    // $data->user_id = $request->user_id;
                    // $data->notification_type = 'order';
                    // $data->order_id = $order_id;
                    // $data->message = 'Order Placed';
                    // $data->save();
                }
                Cart::where('user_id', $request->user_id)->delete();
                return response()->json(['status' => '1', 'message' => 'Oreder Placed Succesfully...!!!'], 200);
            } else {
                return response()->json(['status' => '0', 'message' => 'No Products In Cart'], 400);
            }
        }
    }

    public function order_list(Request $request)
    {
        $validatiion = Validator::make($request->all(), [
            'user_id' => 'required',
        ]);

        if ($validatiion->fails()) {
            return response()->json([
                'status' => '0',
                'message' => 'Validation Error',
                'error' => $validatiion->errors()->getMessages()
            ], 400);
        }

        // $data =   Order::where('user_id', $request->user_id)->with('product')
        //     ->groupBy('order_id')
        //     ->orderBy('updated_at', 'DESC')

        //     ->selectRaw('*, CAST(sum(weight * quantity) as DECIMAL(10,3)) as total')
        //     ->get();
           $orders = Order::where('user_id', $request->user_id)
            ->select(
                'order_id',
                DB::raw('SUM(weight * quantity) as total_weight'),
                DB::raw('MAX(updated_at) as updated_at'),
                DB::raw('MAX(status) as status')
            )
            ->groupBy('order_id')
            ->orderBy('updated_at', 'DESC')
            ->get();

        $orders->each(function ($order) {
            $order->products = Order::where('order_id', $order->order_id)
                ->select('id','order_id','product_id')
                ->with([
                    'product_order' => function ($q) {
                        $q->select('id','name','gallery');
                    }
                ])
                ->get();
        });
        if (count($orders) > 0) {
            return response()->json(['status' => '1', 'message' => 'Ordered List', 'image_url' => asset('public/assets/images/product'), 'data' => $orders], 200);
        } else {
            return response()->json(['status' => '0', 'message' => 'Empty Orders'], 400);
        }
    }

    public function order_detail(Request $request)
    {
        $validatiion = Validator::make($request->all(), [
            'user_id' => 'required',
            'order_id' => 'required',
        ]);

        if ($validatiion->fails()) {
            return response()->json([
                'status' => '0',
                'message' => 'Validation Error',
                'error' => $validatiion->errors()->getMessages()
            ], 400);
        }
        $data = Order::where('user_id', $request->user_id)->where('order_id', $request->order_id)->with('product')->orderBy('updated_at', 'DESC')->get();
        if (count($data) > 0) {
            return response()->json(['status' => '1', 'message' => 'Ordered Details', 'image_url' => asset('public/assets/images/product'), 'data' => $data], 200);
        } else {
            return response()->json(['status' => '0', 'message' => 'Empty Orders'], 400);
        }
    }

    public function detail(Request $request)
    {
        $validatiion = Validator::make($request->all(), [
            'user_id' => 'required',
            'order_id' => 'required',
        ]);

        if ($validatiion->fails()) {
            return response()->json([
                'status' => '0',
                'message' => 'Validation Error',
                'error' => $validatiion->errors()->getMessages()
            ], 400);
        }
        $data['orders'] = Order::where('user_id', $request->user_id)
            ->where('orders.product_id', '!=', '')
            ->where('orders.order_id', $request->order_id)
            ->leftJoin('products', 'products.id', '=', 'orders.product_id')
            ->select(
                'products.*',
                DB::raw('products.name as product_name'),
                DB::raw('products.size as size'),
                DB::raw('products.hole_size as hole_size'),
                DB::raw('products.weight as weight'),
                DB::raw('products.image as product_image'),
                DB::raw('orders.quantity as quantity'),
                DB::raw('orders.status as order_status'),
            )
            ->get();
        $total = Order::where('user_id', $request->user_id)
            ->where('orders.product_id', '!=', '')
            ->where('orders.order_id', $request->order_id)
            ->sum('weight');
        if (count($data['orders']) > 0) {
            return response()->json([
                'status' => '1',
                'message' => 'Ordered Details',
                'image_url' => asset('public/assets/images/product'),
                'total_weight' => number_format($total, '3'),
                'data' => $data
            ], 200);
        } else {
            return response()->json(['status' => '0', 'message' => 'Empty Orders'], 400);
        }
    }
}