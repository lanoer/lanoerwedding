<?php

namespace App\Http\Controllers\Back;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Post;
use App\Models\SubCategory;
use Illuminate\Support\Facades\Storage;
use Intervention\Image\Facades\Image;

class PostController extends Controller
{
    public function __construct()
    {
        $this->middleware('can:read post');
    }
    // CREATE POST
    public function createPost(Request $request)
    {
        $request->validate([
            'post_title' => 'required|unique:posts,post_title',
            'post_content' => 'required',
            'post_category' => 'required|exists:sub_categories,id',
            'featured_image' => 'required|mimes:jpeg,png,jpg|max:2048',
        ], [
            'post_title.required' => 'Judul posts wajib di isi',
            'post_title.unique' => 'Nama judul posts sudah ada',
            'post_content.required' => 'Konten posts wajib di isi',
            'post_category.required' => 'Kategori wajib di pilih',
            'post_category.exists' => 'Kategori tidak ada',
            'featured_image.required' => 'Gambar wajib di pilih',
            'featured_image.mimes' => 'Gambar harus berupa jpeg, png, atau jpg',
            'featured_image.max' => 'Gambar harus kurang dari 2MB',
        ]);

        if ($request->hasFile('featured_image')) {
            $path = 'back/images/post_images/';
            $file = $request->file('featured_image');
            $filename = $file->getClientOriginalName();
            $new_filename = time() . '' . $filename;
            $upload = Storage::disk('public')->put($path . $new_filename, (string) file_get_contents($file));

            $post_thumbnails_path = $path . 'thumbnails';
            if (!Storage::disk('public')->exists($post_thumbnails_path)) {
                Storage::disk('public')->makeDirectory($post_thumbnails_path, 0755, true, true);
            }
            // create square thumbnails
            Image::make(storage_path('app/public/' . $path . $new_filename))
                ->fit(200, 200)->save(storage_path('app/public/' . $path . 'thumbnails/' . 'thumb_' . $new_filename));
            // create resized image
            Image::make(storage_path('app/public/' . $path . $new_filename))
                ->fit(369, 254)->save(storage_path('app/public/' . $path . 'thumbnails/' . 'resized_' . $new_filename));

            if ($upload) {
                $post = new Post();
                $post->author_id = auth()->id();
                $post->category_id = $request->post_category;
                $post->post_title = $request->post_title;
                // $post->slug = Str::slug($request->post_title);
                $post->post_content = $request->post_content;
                $post->featured_image = $new_filename;
                $post->post_tags = $request->post_tags;
                $post->isActive = $request->isActive;
                $post->meta_desc = $request->meta_desc;
                $post->meta_keywords = $request->meta_keywords;
                $saved = $post->save();
                if ($saved) {
                    activity()
                        ->causedBy(auth()->user())
                        ->log('Created post');
                    return response()->json(['code' => 1, 'msg' => 'New Post has been successfuly created.']);
                } else {
                    return response()->json(['code' => 3, 'msg' => 'Something went wrong!']);
                }
            } else {
                return response()->json(['code' => 3, 'msg' => 'Something went wrong for uploading image.']);
            }
        }
    }
    // CONTENT IMAGE BODY
    public function contentImage(Request $request)
    {
        $post = new Post();
        $post->id = 0;
        $post->exists = true;
        $images = $post->addMediaFromRequest('upload')
            ->toMediaCollection('post_content');

        $resizedImageUrl = $images->getUrl('resized');

        return response()->json([
            'url' => $resizedImageUrl,
        ]);
    }
    // EDIT POSTS
    public function editPost(Request $request)
    {
        if (!request()->post_id) {
            return abort(404);
        } else {
            $post = Post::find(request()->post_id);
            $subCat = SubCategory::all();
            $data = [
                'post' => $post,
                'subCat' => $subCat,
                'pageTitle' => 'Edit Post',
            ];

            return view('back.pages.posts.edit-post', $data);
        }
    }
    // UPDATE POSTS
    public function updatePost(Request $request)
    {
        if ($request->hasFile('featured_image')) {

            $request->validate([
                'post_title' => 'required|unique:posts,post_title,' . $request->post_id,
                'post_content' => 'required',
                'post_category' => 'required|exists:sub_categories,id',
                'featured_image' => 'required|mimes:jpeg,png,jpg|max:2048',
            ], [
                'post_title.required' => 'Judul posts wajib di isi',
                'post_title.unique' => 'Nama judul posts sudah ada',
                'post_content.required' => 'Konten posts wajib di isi',
                'post_category.required' => 'Kategori wajib di pilih',
                'post_category.exists' => 'Kategori tidak ada',
                'featured_image.required' => 'Gambar wajib di pilih',
                'featured_image.mimes' => 'Gambar harus berupa jpeg, png, atau jpg',
                'featured_image.max' => 'Gambar harus kurang dari 2MB',
            ]);

            $path = 'back/images/post_images/';

            $path = 'back/images/post_images/';
            $file = $request->file('featured_image');
            $filename = $file->getClientOriginalName();
            $new_filename = time() . '' . $filename;
            $upload = Storage::disk('public')->put($path . $new_filename, (string) file_get_contents($file));

            $post_thumbnails_path = $path . 'thumbnails';
            if (!Storage::disk('public')->exists($post_thumbnails_path)) {
                Storage::disk('public')->makeDirectory($post_thumbnails_path, 0755, true, true);
            }
            // create square thumbnails
            Image::make(storage_path('app/public/' . $path . $new_filename))
                ->fit(200, 200)->save(storage_path('app/public/' . $path . 'thumbnails/' . 'thumb_' . $new_filename));
            // create resized image
            Image::make(storage_path('app/public/' . $path . $new_filename))
                ->fit(369, 254)->save(storage_path('app/public/' . $path . 'thumbnails/' . 'resized_' . $new_filename));

            if ($upload) {

                $old_post_image = Post::find($request->post_id)->featured_image;
                if ($old_post_image != null && Storage::disk('public')->exists($path . $old_post_image)) {
                    Storage::disk('public')->delete($path . $old_post_image);
                    if (Storage::disk('public')->exists($path . 'thumbnails/resized_' . $old_post_image)) {
                        Storage::disk('public')->delete($path . 'thumbnails/resized_' . $old_post_image);
                    }
                    if (Storage::disk('public')->exists($path . 'thumbnails/thumb_' . $old_post_image)) {
                        Storage::disk('public')->delete($path . 'thumbnails/thumb_' . $old_post_image);
                    }
                }

                $post = Post::find($request->post_id);
                $post->category_id = $request->post_category;
                $post->slug = null;
                $post->post_content = $request->post_content;
                $post->post_title = $request->post_title;
                $post->post_tags = $request->post_tags;
                $post->featured_image = $new_filename;
                $post->isActive = $request->isActive;
                $post->meta_desc = $request->meta_desc;
                $post->meta_keywords = $request->meta_keywords;
                $saved = $post->save();

                if ($saved) {
                    activity()
                        ->causedBy(auth()->user())
                        ->log('Updated post');
                    return response()->json(['code' => 1, 'msg' => 'Post has been successfuly updated.']);
                } else {
                    return response()->json(['code' => 3, 'msg' => 'Something went wrong, for updating post.']);
                }
            } else {
                return response()->json(['code' => 3, 'msg' => 'Error in uploading image.']);
            }
        } else {
            $request->validate([
                'post_title' => 'required|unique:posts,post_title,' . $request->post_id,
                'post_content' => 'required',
                'post_category' => 'required|exists:sub_categories,id',
            ]);

            $post = Post::find($request->post_id);
            $post->category_id = $request->post_category;
            $post->slug = null;
            $post->post_content = $request->post_content;
            $post->post_title = $request->post_title;
            $post->post_tags = $request->post_tags;
            $post->isActive = $request->isActive;
            $post->meta_desc = $request->meta_desc;
            $post->meta_keywords = $request->meta_keywords;
            $saved = $post->save();
            if ($saved) {
                activity()
                    ->causedBy(auth()->user())
                    ->log('Updated post');
                return response()->json(['code' => 1, 'msg' => 'Post has been successfuly updated.']);
            } else {
                return response()->json(['code' => 3, 'msg' => 'Something went wrong, for updating post.']);
            }
        }
    }
}
