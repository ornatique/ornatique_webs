<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Link;
use App\Models\Offer;
use Illuminate\Http\Request;
use PDO;

class LinkController extends Controller
{
    public function list(Request $request)
    {
        $data['data'] = Link::all();
        return view('admin.links.link_list', $data);
    }
    public function add(Request $request)
    {
        if ($_POST) {
            $request->validate([
                'name' => 'required|string|max:255',
                'icon' => 'mimes:jpg,jpeg,png|required|max:2048',
                'link' => 'required|max:255'
            ]);
            $data = new Link;
            $data->name = $request->name;
            $data->link = $request->link;
            if ($request->icon) {
                $thumb = $request->file('icon');
                $thumb_file = $this->uploadImage($thumb, '');
                $data->icon = $thumb_file;
            }
            $data->save();
            return redirect()->route('admin_links_list')->with('msg', 'Link Added Successfully.');
        }
        return view('admin.links.link_add');
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
                'name' => 'required|string|max:255',
                'icon' => 'mimes:jpg,jpeg,png|max:2048',
                'link' => 'required|max:255'
            ]);
            $data =  Link::find($id);
            $data->name = $request->name;
            $data->link = $request->link;
            if ($request->icon) {
                $thumb = $request->file('icon');
                $thumb_file = $this->uploadImage($thumb, '');
                $data->icon = $thumb_file;
            }
            $data->save();
            return redirect()->route('admin_links_list')->with('msg', 'Link Edited Successfully.');
        }
        $data['data'] = Link::find($id);
        return view('admin.links.link_edit', $data);
    }
    public function delete(Request $request)
    {
        if ($_POST) {
            $data = Link::find($request->id);
            if ($data) {
                $data->delete();
                return Redirect(route('admin_links_list'))->with('msg', 'Link Deleted Successfully..!!');
            }
        }
    }
}