<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Social;
use Illuminate\Http\Request;

class SocialController extends Controller
{
    public function list(Request $request)
    {
        $data['data'] = Social::all();
        return view('admin.social.link_list', $data);
    }
    public function add(Request $request)
    {
        if ($_POST) {
            $request->validate([
                'facebook' => 'required',
                'twitter' => 'required',
                'instagram' => 'required',
                'linkedin' => 'required',
                'whatsapp' => 'required',
                'youtube' => 'required',
            ]);
            $data = new Social;
            $data->facebook = $request->facebook;
            $data->twitter = $request->twitter;
            $data->instagram = $request->instagram;
            $data->linkedin = $request->linkedin;
            $data->whatsapp = $request->whatsapp;
            $data->youtube = $request->youtube;

            $data->save();
            return redirect()->route('admin_social_list')->with('msg', 'Link Added Successfully.');
        }
        return view('admin.social.link_add');
    }
    public function uploadImage($file, $dir)
    {
        $extension = $file->getClientOriginalExtension();
        $name = str_replace(' ', '-', $file->getClientOriginalName());
        $filename =  $name;
        $file->move("public/assets/images/links/", $filename);
        return $filename;
    }
    public function edit(Request $request, $id)
    {
        if ($_POST) {
            $request->validate([
                'facebook' => 'required',
                'twitter' => 'required',
                'instagram' => 'required',
                'linkedin' => 'required',
                'whatsapp' => 'required',
                'youtube' => 'required',
            ]);
            $data =  Social::find($id);
            $data->facebook = $request->facebook;
            $data->twitter = $request->twitter;
            $data->instagram = $request->instagram;
            $data->linkedin = $request->linkedin;
            $data->whatsapp = $request->whatsapp;
            $data->youtube = $request->youtube;
            $data->save();
            return redirect()->route('admin_social_list')->with('msg', 'Link Edited Successfully.');
        }
        $data['data'] = Social::find($id);
        return view('admin.social.link_edit', $data);
    }
    public function delete(Request $request)
    {
        if ($_POST) {
            $data = Social::find($request->id);
            if ($data) {
                $data->delete();
                return Redirect(route('admin_social_list'))->with('msg', 'Link Deleted Successfully..!!');
            }
        }
    }
}
