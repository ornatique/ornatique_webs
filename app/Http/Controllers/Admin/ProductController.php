<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Category;
use App\Models\Product;
use App\Models\Subcategory;
use App\Models\User;
use App\Models\Cart;
use App\Models\Wishlist;
use BaconQrCode\Encoder\QrCode;
use Illuminate\Http\Request;
use DataTables;
use SimpleSoftwareIO\QrCode\Facades\QrCode as FacadesQrCode;
use App\Helpers\FCMManualHelper;


class ProductController extends Controller
{
    public function list(Request $request)
    {
        $product = Product::orderBy('created_at', 'DESC');
        if ($request->q) {
            $data['q'] = $request->q;
            $product->where('name', 'like', '%' . $request->q . '%');
            $cat = Category::where('name', 'like', '%' . $request->q . '%')->pluck('id');
            $sub = Subcategory::where('name', 'like', '%' . $request->q . '%')->pluck('id');
            if ($cat) {
                $product->orWhereIn('category_id',  $cat);
            }
            if ($sub) {
                $product->orWhereIn('subcategory_id',  $sub);
            }
        }
        if ($request->pagination) {
            $data['pagi'] = $request->pagination;
            $data['data'] = $product->paginate($request->pagination);
        } else {
            $data['data'] = $product->paginate(25);
        }
        // Product::where('subcategory_id')
        return view('admin.product.product_list', $data);
    }

    public function add(Request $request)
    {
        if ($request->isMethod('post')) {

            $request->validate([
                'name' => 'required|string|min:2|max:255',
                'sub_category' => 'required',
                'hole_size' => 'nullable',
            ]);

            $data = new Product();
            $data->name = $request->name;
            $data->charge = $request->charge;
            $data->label_product = $request->label_product;
            $data->color = $request->color;
            $data->bg_color = $request->bg_color;
            $data->category_id = $request->category;
            $data->subcategory_id = $request->sub_category;
            $data->size = $request->size;
            $data->hole_size = $request->hole_size;
            $data->gross_weight = $request->gross_weight;
            $data->less_weight = $request->less_weight;
            $data->weight = number_format($request->weight, 3);

            if ($request->gallery) {
                $data->gallery = json_encode($request->gallery);
            }

            $data->save();

            // ✅ FCM push using your helper
            // $firebaseUsers = User::whereNotNull('token')->where('token', '!=', '')->get();

            // foreach ($firebaseUsers as $user) {
            //     try {
            //         FCMManualHelper::sendPush($user->token, 'Ornatique', 'Product Added by Ornatique');
            //     } catch (\Exception $e) {
            //         \Log::error('FCM failed for user ' . $user->id . ': ' . $e->getMessage());
            //     }
            // }

            // \Log::info('All manual FCM push notifications sent for product creation.');

            return redirect()
                ->route('admin_product_list')
                ->with('msg', 'Product Added Successfully..!!');
        }

        $data['categories'] = Category::all();
        $data['sub_categories'] = Subcategory::all();
        return view('admin.product.product_add', $data);
    }

    public function edit(Request $request, $id)
    {
        if ($_POST) {
            $request->validate([
                'name' => 'required|string|min:2|max:255',
                'category' => 'required',
                // 'sub_category' => 'required',
                // 'number' => 'required|digits:10',
                // 'size' => 'required',
                // 'gross_weight' => 'required',
                // 'less_weight' => 'required',
                // 'hole_size' => 'nullable',
                // 'weight' => 'required',
                // 'image' => 'image|mimes:jpeg,png,jpg,gif,svg|max:2048',
            ]);
            $data = Product::find($id);
            $data->name = $request->name;
            $data->charge = $request->charge;
            $data->label_product = $request->label_product;
            $data->color = $request->color;
            $data->category_id = $request->category;
            $data->subcategory_id = $request->sub_category;
            $data->bg_color = $request->bg_color;
            // $data->number = $request->number;
            $data->size = $request->size;
            $data->hole_size = $request->hole_size;
            $data->gross_weight = $request->gross_weight;
            $data->less_weight = $request->less_weight;
            // $image = \QrCode::size(300)->generate($data->id);
            // $data->qr_code = $image;
            $data->weight = number_format($request->weight, 3);
            if ($request->gallery) {
                $data->gallery = json_encode($request->gallery);
            }
            // return $data;
            $data->save();
            return redirect()
                ->route('admin_product_list')
                ->with('msg', 'Product Edited Successfully..!!');
        }
        $data['data'] = Product::find($id);
        $data['categories'] = Category::all();
        // $data['sub_categories'] = Subcategory::where('category_id', $data['data']->category_id)->get();
        $data['sub_categories'] = Subcategory::all();
        return view('admin.product.product_edit', $data);
    }


    public function uploadImage($file, $dir)
    {
        $extension = $file->getClientOriginalExtension();
        $name = str_replace(' ', '-', $file->getClientOriginalName());
        $filename = $name;
        $file->move('public/assets/images/product/', $filename);
        return $filename;
    }

    public function upload(Request $request)
    {
        if ($request->hasFile('image')) {

            $data = $this->validate($request, [
                // 'image' => 'upload-image'
                'image' => 'nullable|file|mimes:jpg,jpeg,png,bmp,tiff,gif|max:8192',
            ]);
            $image = $request->file('image');
            $file_name = $this->uploadImage($image, '', $request->path);
            return [
                "code" => 200,
                "status" => "success",
                "file_name" => $file_name
            ];
        }
        return [
            "code" => 404,
            "status" => "no file"
        ];
    }
    public function delete(request $request)
    {
        // return $request;
        if ($_POST) {
            $data = Product::find($request->id);
            Cart::where('product_id', $request->id)->delete();
            Wishlist::where('product_id', $request->id)->delete();
            if ($data) {
                $data->delete();
                return response()->json(['msg' => 'Product Deleted Successfully..!!']);
            } else {
                return response()->json(['msg' => 'Product Already Deleted. Reload to see..!!']);
            }
            // Product::where('id', $request->id)->delete();
            return Redirect()
                ->back()
                ->with('msg', 'Product Deleted Successfully..!!');
        }
    }
    public function getStudents(Request $request)
    {
        if ($request->ajax()) {
            $data = Product::orderBy('created_at', 'DESC')->get();
            return Datatables::of($data)
                // ->addIndexColumn()
                ->order(function ($query) {
                    if (request()->has('id')) {
                        $query->orderBy('id', 'desc');
                    }
                })
                ->setRowId(function ($user) {
                    return 'tr' . $user->id;
                })
                ->addColumn('index', function ($row) {
                    $index = '<input type="checkbox" name="product_id" value="' . $row->id . '"
                                                class="product_ids">
                                            ' . $row->id . '';
                    return $index;
                })
                ->addColumn('action', function ($row) {
                    $actionBtn = '<a href="' . url("admin/product/edit") . "/" . $row->id . ' "class="btn btn-primary"> <i class="bx bx-pencil"></i> Edit</a>';
                    return $actionBtn;
                })
                ->addColumn('delete', function ($row) {
                    $fun = 'DeleteUser(' . $row->id . ',"tr' . $row->id . '")';
                    $deleteBtn = '<a href="#" onClick=' . $fun . ' class="btn btn-danger"> <i class="bx bx-trash-alt"></i> Delete</a>';
                    return $deleteBtn;
                })
                ->addColumn('image', function ($row) {
                    $image = '<img width="80"src="' . asset("public/assets/images/product") . "/" . $row->image . '" alt="">';
                    return $image;
                })
                ->addColumn('category_id', function ($row) {
                    $category_id = ($row->category ? $row->category->name : '');
                    return $category_id;
                })
                ->addColumn('subcategory_id', function ($row) {
                    $subcategory_id = ($row->subcategory ? $row->subcategory->name : '');
                    return $subcategory_id;
                })
                ->addColumn('product_qr', function ($row) {
                    $product_qr = '<span class="me-5"><a href="' . route('download.image', $row->id) . '" target="_blank" download>
                                                    ' . FacadesQrCode::size(50)->generate($row->id) . '</a>
                                            </span>
                                            <button class="btn btn-success print_qr" data-qr-name="' . $row->id . '">QR
                                            </button>';
                    return $product_qr;
                })
                ->rawColumns(['image', 'category_id', 'subcategory_id', 'action', 'delete', 'product_qr', 'index'])
                ->make(true);
        }
    }
}
