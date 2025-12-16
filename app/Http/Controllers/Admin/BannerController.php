<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Banner;
use Illuminate\Http\Request;

class BannerController extends Controller
{
    public function index(request $request)
    {
        $data['data'] = Banner::first();
        return view('admin.banner', $data);
    }

    public function list(request $request)
    {
        $data['data'] = Banner::first();
        return view('admin.banner_list', $data);
    }






    public function edit(Request $request, $id = '')
    {
        if ($_POST) {
            $data = Banner::first();
            // if ($request->gallery_cat) {
            //     $gallery_cat = json_encode($request->gallery_cat);
            //     $data->gallery_cat = $gallery_cat;
            // }
            // if ($request->gallery_adv) {
            //     $gallery_adv = json_encode($request->gallery_adv);
            //     $data->gallery_adv = $gallery_adv;
            // }

            if ($request->image) {
                $thumb = $request->file('image');
                $thumb_file = $this->uploadImage($thumb, '');
                $data->gallery_adv = $thumb_file;
            }

            $data->save();
            return redirect()->route('admin_banners');
            return view('admin.banners', ['data' => $data]);
        }
    }

    public function uploadImage($file, $dir)
    {
        //$file = $request->file('image');
        $extension = $file->getClientOriginalExtension();

        $name = $file->getClientOriginalName();

        $filename = time() . '-' . $name;

        $file->move("public/assets/images/banners/", $filename);

        return $filename;
    }

    public function upload(Request $request)
    {
        if ($request->hasFile('image')) {

            $data = $this->validate($request, [
                'gallery_adv' => 'mimes:jpeg,jpg,png,gif|max:3062'
            ]);

            $image = $request->file('image');
            $file_name = $this->uploadImage($image, '');

            return [
                "code" => 200,
                "status" => "success",
                "file_name" => $file_name
            ];
        }
        if ($request->hasFile('image')) {

            $data = $this->validate($request, [
                'gallery_cat' => 'mimes:jpeg,jpg,png,gif|max:3062'
            ]);

            $image = $request->file('image');
            $file_name = $this->uploadImage($image, '');

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
}