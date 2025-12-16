<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Media;
use Illuminate\Http\Request;
use App\Helpers\FCMManualHelper;
use App\Models\Category;
use App\Models\Media_comment;
use App\Models\Media_like;
use App\Models\Subcategory;
use App\Models\User;

class MediaController extends Controller
{
    public function list()
    {
        // Load likes_count, and all comments with user relation
        $data['data'] = Media::with(['comments.user'])->withCount(['likes'])->get();

        return view('admin.media.media_list', $data);
    }




    // public function add(Request $request)
    // {

    //     // return $request;

    //     if ($request->isMethod('post')) {
    //         $request->validate([
    //             'name' => 'required|string|min:2|max:255',
    //             'description' => 'nullable|string',
    //             'category_id' => 'nullable|integer',
    //             'subcategory_id' => 'nullable|integer',
    //             'media_file' => 'nullable|file|max:50480',
    //         ]);

    //         $data = new Media();
    //         $data->name = $request->name;
    //         $data->description = $request->description;
    //         $data->category_id = $request->category_id;
    //         $data->subcategory_id = $request->subcategory_id;

    //         if ($request->hasFile('media_file')) {
    //             $file = $request->file('media_file');
    //             $filename = time() . '_' . $file->getClientOriginalName();
    //             $file->move(public_path('assets/images/media'), $filename);
    //             $data->media_file =  $filename;
    //         }


    //         if ($request->hasFile('image')) {
    //             $file_image = $request->file('image');
    //             $filename_image = time() . '_' . $file_image->getClientOriginalName();
    //             $file_image->move(public_path('assets/images/media'), $filename_image);
    //             $data->image =  $filename_image;
    //         }

    //         $data->save();

    //         // ✅ FCM Notification
    //         $firebaseUsers = User::whereNotNull('token')->where('token', '!=', '')->get();

    //         foreach ($firebaseUsers as $user) {
    //             try {
    //                 FCMManualHelper::sendPush(
    //                     $user->token,
    //                     'Ornatique',
    //                     'A new media has been uploaded!'
    //                 );
    //             } catch (\Exception $e) {
    //                 \Log::error('FCM failed for user ' . $user->id . ': ' . $e->getMessage());
    //             }
    //         }

    //         $imageUrl = null;

    //         $firebaseUsers = User::whereNotNull('token')->where('token', '!=', '')->get();

    //         $categoryName = optional($data->category)->name;
    //         $subcategoryName = optional($data->subcategory)->name;

    //         $pushTitle = $data->title;
    //         $pushBody = $data->description . ' (' . ucwords($categoryName) . ' / ' . ucwords($subcategoryName) . ')';

    //         foreach ($firebaseUsers as $user) {
    //             FCMManualHelper::sendPushWithImage(
    //                 $user->token,
    //                 $pushTitle,
    //                 $pushBody,
    //                 $imageUrl
    //             );
    //         }

    //         \Log::info('All FCM push notifications sent for media creation.');

    //         return redirect()->route('admin_media_list')->with('msg', 'Media Added Successfully!');
    //     }

    //     $data['categories'] = Category::all();
    //     $data['sub_categories'] = Subcategory::all();
    //     return view('admin.media.media_add', $data);
    // }

    public function add(Request $request)
    {
        if ($request->isMethod('post')) {
            $request->validate([
                'name' => 'required|string|min:2|max:255',
                'description' => 'nullable|string',
                'category_id' => 'nullable|integer',
                'subcategory_id' => 'nullable|integer',
                'media_file' => 'nullable|file|max:50480',
                'image' => 'nullable|image|mimes:jpg,jpeg,png|max:2048',
            ]);

            $media = new Media();
            $media->name = $request->name;
            $media->description = $request->description;
            $media->category_id = $request->category_id;
            $media->subcategory_id = $request->subcategory_id;

            // Upload media file
            if ($request->hasFile('media_file')) {
                $file = $request->file('media_file');
                $filename = time() . '_' . $file->getClientOriginalName();
                $file->move(public_path('assets/images/media'), $filename);
                $media->media_file = $filename;
            }

            // Upload image file (optional)
            $imageUrl = null;
            if ($request->hasFile('image')) {
                $fileImage = $request->file('image');
                $filenameImage = time() . '_' . $fileImage->getClientOriginalName();
                $fileImage->move(public_path('assets/images/media'), $filenameImage);
                $media->image = $filenameImage;

                // Create full public URL for push notification
                $imageUrl = asset('public/assets/images/media/' . $filenameImage);
            }

            $media->save();

            // 🔔 Send FCM Notification (Dynamic like your first function)
            $firebaseUsers = User::whereNotNull('token')->where('token', '!=', '')->get();

            $categoryName = optional($media->category)->name;
            $subcategoryName = optional($media->subcategory)->name;

            $pushTitle = $media->name; // using 'name' instead of 'title'
            $pushBody = ($media->description ?? 'New media added') .
                ' (' . ucwords($categoryName) . ' / ' . ucwords($subcategoryName) . ')';

            foreach ($firebaseUsers as $user) {
                try {
                    FCMManualHelper::sendPushWithImage(
                        $user->token,
                        $pushTitle,
                        $pushBody,
                        $imageUrl
                    );
                } catch (\Exception $e) {
                    \Log::error('FCM failed for user ' . $user->id . ': ' . $e->getMessage());
                }
            }

            \Log::info('Dynamic FCM push notifications sent for new media.');

            return redirect()->route('admin_media_list')->with('msg', 'Media Added Successfully!');
        }

        $data['categories'] = Category::all();
        $data['sub_categories'] = Subcategory::all();
        return view('admin.media.media_add', $data);
    }



    public function edit(Request $request, $id)
    {
        $media = Media::findOrFail($id);

        if ($request->isMethod('post')) {
            $request->validate([
                'name' => 'required|string|min:2|max:255',
                'description' => 'nullable|string',
                'category_id' => 'nullable|integer',
                'subcategory_id' => 'nullable|integer',
                'media_file' => 'nullable|file|max:50480',
            ]);

            $media->name = $request->name;
            $media->description = $request->description;
            $media->category_id = $request->category_id;
            $media->subcategory_id = $request->subcategory_id;

            if ($request->hasFile('media_file')) {
                $file = $request->file('media_file');
                $filename = time() . '_' . $file->getClientOriginalName();
                $file->move(public_path('assets/images/media'), $filename);
                $media->media_file =  $filename;
            }


            if ($request->hasFile('image')) {
                $file_image = $request->file('image');
                $filename_image = time() . '_' . $file_image->getClientOriginalName();
                $file_image->move(public_path('assets/images/media'), $filename_image);
                $media->image =  $filename_image;
            }

            $media->save();

            return redirect()->route('admin_media_list')->with('msg', 'Media Updated Successfully!');
        }

        $data['media'] = $media;
        $data['categories'] = Category::all();
        $data['sub_categories'] = Subcategory::all();
        return view('admin.media.media_edit', $data);
    }

    public function delete(Request $request)
    {
        if ($request->isMethod('post')) {
            $media = Media::find($request->id);
            if ($media) {
                $media->delete();
                return response()->json(['msg' => 'Media Deleted Successfully!']);
            } else {
                return response()->json(['msg' => 'Media Not Found!']);
            }
        }
    }



    public function list_like()
    {
        $data['data'] = \App\Models\Media_like::with('media')
            ->select('media_id')
            ->selectRaw('COUNT(user_id) as like_count')
            ->groupBy('media_id')
            ->get();

        return view('admin.like.list', $data);
    }


    public function list_comment()
    {
        $data['data'] = Media_comment::with('media')->with('user')->get();
        // return $data;
        return view('admin.comment.list', $data);
    }


    // public function comment_edit(Request $request, $id)
    // {
    //     return view('admin.comment.edit');
    // }

    public function comment_delete(Request $request)
    {
        if ($request->isMethod('post')) {
            $media = Media_comment::find($request->id);
            if ($media) {
                $media->delete();
                return response()->json(['msg' => 'Media Comment Deleted Successfully!']);
            } else {
                return response()->json(['msg' => 'Media Not Found!']);
            }
        }
    }

    public function comment_edit(Request $request)
    {
        $request->validate([
            'id' => 'required|integer',
            'comment' => 'required|string|max:500',
        ]);

        $comment = Media_comment::find($request->id);

        if (!$comment) {
            return response()->json(['msg' => 'Comment not found!'], 404);
        }

        $comment->comment = $request->comment;
        $comment->save();

        return response()->json(['msg' => 'Comment updated successfully!']);
    }
}