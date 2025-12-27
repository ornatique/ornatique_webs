<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Category;
use App\Models\Custum_order;
use App\Models\Notification;
use App\Models\Offer;
use Illuminate\Foundation\Auth\RegistersUsers;
use App\Models\Subcategory;
use App\Models\Product;
use App\Models\User;
use Illuminate\Support\Facades\Auth;
use App\Models\Order;
use App\Models\Privacy;
// use Barryvdh\DomPDF\PDF;
// use Barryvdh\DomPDF\Facade\Pdf;
// use Barryvdh\DomPDF\Facade as PDF;
use Barryvdh\DomPDF\PDF as DomPdf;
use Dompdf\FrameDecorator\Image;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Storage;
use App\Helpers\FCMManualHelper;
use App\Models\Collection;
use App\Models\Essential;
use App\Models\Heading;
use App\Models\Layout;
use App\Models\Media;
use App\Models\Store;
use App\Models\Task;

class HomeController extends Controller
{
    use
        RegistersUsers;


    // public function index(Request $request)
    // {
    //     $data['category'] = Category::count();
    //     $data['subcategory'] = Subcategory::count();
    //     $data['product'] = Product::count();
    //     $data['users'] = User::where('admin', '0')->where('status', '1')->count();
    //     $data['orders'] = Order::distinct('order_id')->count('order_id');
    //     $data['custom'] = Custum_order::count(); // then overwritten by Task::count()
    //     $data['new_users'] = User::where('admin', '0')->where('status', '0')->count();
    //     $data['admin'] = User::where('admin', '1')->count();
    //     $data['notis'] = Notification::count();
    //     $data['offer'] = Offer::count();
    //     $data['tasks'] = Task::count();
    //     $data['media'] = Media::count();
    //     $data['essential'] = Essential::count();
    //     $data['collection'] = Collection::count();
    //     $data['store'] = Store::count();
    //     $data['headings'] = Heading::count();
    //     $data['layouts'] = Layout::count();
    //     // return $data;
    //     return view('admin.home', $data);
    // }

    public function index(Request $request)
    {
        // Your existing counts
        $data['category'] = Category::count();
        $data['subcategory'] = Subcategory::count();
        $data['product'] = Product::count();
        $data['users'] = User::where('admin', '0')->where('status', '1')->count();
        $data['orders'] = Order::distinct('order_id')->count('order_id');
        $data['custom'] = Custum_order::count();
        $data['new_users'] = User::where('admin', '0')->where('status', '0')->count();
        $data['admin'] = User::where('admin', '1')->count();
        $data['notis'] = Notification::count();
        $data['offer'] = Offer::count();
        $data['tasks'] = Task::count();
        $data['media'] = Media::count();
        $data['essential'] = Essential::count();
        $data['collection'] = Collection::count();
        $data['store'] = Store::count();
        $data['headings'] = Heading::count();
        $data['layouts'] = Layout::count();

        // Order analytics data for graphs
        $data['monthly_orders'] = $this->getMonthlyOrders();
        $data['order_status_data'] = $this->getOrderStatusData();
        $data['revenue_trend'] = $this->getRevenueTrend();


        return view('admin.home', $data);
    }

    private function getMonthlyOrders()
    {
        // Get orders from last 6 months
        return [
            'labels' => ['Jan', 'Feb', 'Mar', 'Apr', 'May', 'Jun'],
            'data' => [65, 59, 80, 81, 56, 55]
        ];
    }

    private function getOrderStatusData()
    {
        return [
            'labels' => ['Completed', 'Pending', 'Processing', 'Cancelled'],
            'data' => [45, 25, 20, 10],
            'colors' => ['#10b981', '#f59e0b', '#3b82f6', '#ef4444']
        ];
    }

    private function getRevenueTrend()
    {
        return [
            'labels' => ['Week 1', 'Week 2', 'Week 3', 'Week 4'],
            'data' => [12500, 18900, 15800, 22000]
        ];
    }



    public function ajaxStatusChange(Request $request)
    {

        $model = 'App\Models\\' . $request->model;
        $data = $model::find($request->id);
        $active = $model::ACTIVE;
        $data->$active = $request->status;
        $data->save();

        return $data;
    }

    public function ajaxStatusChangeAdmin(Request $request)
    {

        $model = 'App\Models\\' . $request->model;
        $data = $model::find($request->id);
        $active = $model::Admin;
        $data->$active = $request->status;
        $data->save();
        return $data;
    }

    public function detail(Request $request, $name)
    {
        $data['data'] = Order::where('order_id', $name)
            ->get();
        $data['id'] = $name;
        // return $data;
        return view('admin.order_detail', $data);
    }

    public function list(Request $request)
    {
        $data['data'] = User::where('admin', '0')->where('status', '1')->get();
        return view('admin.custumer_list', $data);
    }
    // public function new_list(Request $request)
    // {
    //     $data['data'] = User::where('admin', '0')->where('status', '0')->get();
    //     return view('admin.custumer_list', $data);
    // }

    public function new_list(Request $request)
    {
        $query = User::where('admin', '0')
            ->where('status', '0'); // only active users

        if ($request->filter) {
            if ($request->filter == 'last_10_days') {
                $query->where('created_at', '>=', now()->subDays(10));
            } elseif ($request->filter == 'last_15_days') {
                $query->where('created_at', '>=', now()->subDays(15));
            } elseif ($request->filter == 'last_month') {
                $query->where('created_at', '>=', now()->subMonth());
            } elseif ($request->filter == 'last_3_months') {
                $query->where('created_at', '>=', now()->subMonths(3));
            } elseif ($request->filter == 'last_6_months') {
                $query->where('created_at', '>=', now()->subMonths(6));
            }
        }

        $data['data'] = $query->get();

        return view('admin.custumer_list', $data);
    }





    // public function orderStatusChange(Request $request)
    // {
    //     $order_id = '';
    //     if ($request->custom) {
    //         $data =  Custum_order::find($request->id);
    //         $data->status = $request->status;
    //         $user_id = $data->user_id;
    //         $data->save();
    //     } else {
    //         $data =  Order::find($request->id);
    //         $order_id = $data->order_id;
    //         $user_id = $data->user_id;
    //         $data->status = $request->status;
    //         $data->save();
    //     }
    //     $firebaseTokens = User::where('id', $request->user_id)->whereNotNull('device_token')->get();
    //     // $firebaseToken = User::whereNotNull('device_token')->pluck('device_token')->all();
    //     $msg = '';
    //     if ($request->status == 'Pending') {
    //         $msg = 'Your Order is Recieved.';
    //     } elseif ($request->status == 'Approval') {
    //         $msg = 'Your Order has been accepted.';
    //     } elseif ($request->status == 'Making') {
    //         $msg = 'Your Order is under making.';
    //     } elseif ($request->status == 'Finishing') {
    //         $msg = 'Your Order is under finishing.';
    //     } elseif ($request->status == 'Done') {
    //         $msg = 'Your Order is ready for delivery. Thank You.';
    //     }
    //     $data = new Notification();
    //     $data->user_id = $user_id;
    //     $data->notification_type = 'order';
    //     $data->order_id = $order_id;
    //     $data->message = $msg;
    //     $data->save();
    //     $SERVER_API_KEY = 'qRJCD7MfeIKY5Qrh2Rs2_tdO9sJ_UMesLMoEd1CnkV8';
    //     if (count($firebaseTokens) > 0) {
    //         foreach ($firebaseTokens  as $firebaseToken) {
    //             $data = [
    //                 // "registration_ids" => $firebaseToken->device_token,
    //                 'to' => $firebaseToken->device_token,
    //                 "notification" => [
    //                     "title" => 'Ornatique',
    //                     "body" => $msg,
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
    //         }
    //     }
    //     return;
    // }


    public function orderStatusChange(Request $request)
    {
        $order_id = '';
        $user_id = $request->user_id;
        if ($request->custom) {
            $data = Custum_order::where('user_id', $user_id)->first();
            $data->status = $request->status;
            $user_id = $data->user_id;
            $data->save();
        } else {
            $data = Order::where('user_id', $user_id)->first();
            $order_id = $data->order_id;
            $user_id = $data->user_id;
            $data->status = $request->status;
            $data->save();
        }

        // Message based on status
        $msg = match ($request->status) {
            'Pending' => 'Your Order is Received.',
            'Approval' => 'Your Order has been accepted.',
            'Making' => 'Your Order is under making.',
            'Finishing' => 'Your Order is under finishing.',
            'Done' => 'Your Order is ready for delivery. Thank You.',
            default => '',
        };

        // Save notification
        $notify = new Notification();
        $notify->user_id = $user_id;
        $notify->notification_type = 'order';
        $notify->order_id = $order_id;
        $notify->message = $msg;
        $notify->save();

        // Send FCM Notification using your helper
        $firebaseUsers = User::where('id', $user_id)->whereNotNull('token')->where('token', '!=', '')->get();

        foreach ($firebaseUsers as $user) {
            try {
                FCMManualHelper::sendPush($user->token, 'Ornatique', $msg);
            } catch (\Exception $e) {
                \Log::error('FCM failed for user ' . $user->id . ': ' . $e->getMessage());
            }
        }

        \Log::info('Order status updated and FCM notification sent.', [
            'user_id' => $user_id,
            'status' => $request->status,
            'message' => $msg
        ]);

        return;
    }



    /**
     * Create a new controller instance.
     *
     * @return void
     */
    /**
     * Show the application dashboard.
     *
     * @return \Illuminate\Contracts\Support\Renderable
     */
    /**
     * Write code on Method
     *
     * @return response()
     */
    public function saveToken(Request $request)
    {
        // return $request->token;
        User::where('id', Auth::id())->update(['device_token' => $request->token]);
        return response()->json(['token saved successfully.']);
    }

    /**
     * Write code on Method
     *
     * @return response()
     */
    public function sendNotification(Request $request)
    {
        $firebaseToken = User::whereNotNull('device_token')->pluck('device_token')->all();

        $SERVER_API_KEY = 'fhiWIucATW25FFkQEvFHRB:APA91bEvnM_8XK7UIi4HOs542fsxAA_L7OIFwOwBtVE4fXFTa_lFYrWJ-TPyYV-msfDxmUKcWdURIZjAB7uA9wcuuy9rLhE5O58d00u4ZAkF60LPqHOQb7g';

        $data = [
            "registration_ids" => $firebaseToken,
            // 'to' => 'BPvdKB5sL7PMnBadBMwOWwLcUvCGsJXZ4CMFOINbA9MRvzaGr7U7uXIvyhs8igF_rk54_ipFoQyNoO6jDSHcMzw',
            "notification" => [
                "title" => $request->title,
                "body" => $request->body,
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
        return redirect()->back()->with('msg', $response);
        dd($response);
    }

    private function invoiceData($order_id)
    {
        
        return [
            'data' => Order::with(['user', 'products'])
                ->where('order_id', $order_id)
                ->get(),

            'total_quantity' => Order::where('order_id', $order_id)
                ->sum('quantity'),

            'order_id' => Order::with('user')
                ->where('order_id', $order_id)
                ->first(),
        ];
    }

    public function invoice(Request $request, $order_id)
    {
       
        $data= $this->invoiceData($order_id);
        $data['is_pdf'] = false;
        return view('admin.invoice', $data);
    }

    public function pdf($order_id)
    {
        $data = $this->invoiceData($order_id);

        /** @var DomPdf $pdf */
        $pdf = app()->make(DomPdf::class);
        $pdf->setOptions([
        'isRemoteEnabled' => true,
        'chroot' => base_path(), // ✅ THIS FIXES IMAGE ISSUE
    ]);
        $pdf->loadView('admin.invoice', array_merge($data, [
            'is_pdf' => true
        ]));

        return $pdf->download($order_id . '-invoice.pdf');
    }
    // public function pdf(Request $request, $order_id)
    // {
        
    //     $data = $this->invoiceData($order_id);
    //     $pdf = PDF::loadView('admin.invoice', array_merge($data, [
    //         'is_pdf' => true
    //     ]));
        
    //     return $pdf->download($order_id . '-invoice.pdf');

    // }

    public function custom_invoice(Request $request, $id)
    {
        $data['data'] =  Custum_order::find($id);
        $data['is_pdf'] = false;
        return view('admin.custom-invoice', $data);
        return $data;
    }
    public function qr(Request $request, $name)
    {
        $data['product'] = Product::find($name);
        // return $data;
        return view('admin.qr', $data);
    }
    public function qrs(Request $request)
    {
        if ($request->product_ids) {
            $ids = explode(',', $request->product_ids);
            $data['products'] = Product::whereIn('id', $ids)->get();
            return view('admin.qrs', $data);
        } else {
            return 'Please Select Product';
        }
    }
    public function downloadImage(Image $image, $qr)
    {
        $imagePath = Storage::url($qr);
        return response()->download(public_path($imagePath));
    }

    public function privacy_policy(Request $request)
    {
        $data['data'] = Privacy::first();
        return view('admin.privacy_policy', $data);
    }
    public function privacy_policy_edit(Request $request)
    {
        if ($_POST) {
            $data = Privacy::first();
            $data->privacy =  $request->privacy;
            $data->terms =  $request->terms;
            $data->save();
            return redirect(route('admin_privacy_policy'));
        }
        $data['data'] = Privacy::first();
        return view('admin.privacy_policy_edit', $data);
    }
}
