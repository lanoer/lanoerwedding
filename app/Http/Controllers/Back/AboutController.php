<?php

namespace App\Http\Controllers\Back;

use App\Http\Controllers\Controller;
use App\Models\About;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Str;

class AboutController extends Controller
{

    public function __construct()
    {
        $this->middleware('can:read content');
    }

    public function mainAbout()
    {
        $about = About::first();
        $pageTitle = 'About Us';
        return view('back.pages.about.index', compact('about', 'pageTitle'));
    }
    public function editAbout($id)
    {
        $about = About::findOrFail($id);
        $pageTitle = 'Edit About Us';
        // Menggunakan compact untuk mengirim data ke view
        return view('back.pages.about.edit', compact('about', 'pageTitle'));
    }


    // Update data About
    public function updateAbout(Request $request, $id)
    {
        $rules = [
            'title' => 'required|unique:abouts,title,' . $id,
            'description' => 'required',
            'meta_description' => 'required',
            'meta_keywords' => 'required',
            'meta_tags' => 'required',
            'image' => 'nullable|image|mimes:jpeg,png,jpg|max:2048',
        ];

        $messages = [
            'title.required' => 'Title is required',
            'title.unique' => 'Title must be unique',
            'description.required' => 'Description is required',
            'meta_description.required' => 'Meta description is required',
            'meta_keywords.required' => 'Meta keywords are required',
            'meta_tags.required' => 'Meta tags are required',
            'image.image' => 'Image must be a valid image file',
            'image.mimes' => 'Image must be a jpeg, png, or jpg file',
            'image.max' => 'Image size must not exceed 2MB',
        ];
        $validator = Validator::make($request->all(), $rules, $messages);

        if ($validator->fails()) {
            return response()->json([
                'success' => false,
                'errors' => $validator->errors()
            ]);
        }

        $about = About::findOrFail($id);  // Mencari data yang akan diperbarui

        // Update title
        $about->title = $request->title;
        $about->description = $request->description;
        $about->meta_description = $request->meta_description;
        $about->meta_keywords = $request->meta_keywords;
        $about->meta_tags = $request->meta_tags;

        // Jika ada gambar yang di-upload
        if ($request->hasFile('image')) {
            $path = 'back/images/about/';

            // Hapus gambar lama jika ada
            if ($about->image && Storage::disk('public')->exists($path . $about->image)) {
                Storage::disk('public')->delete($path . $about->image);
            }

            // Simpan gambar baru
            $image = $request->file('image');
            $filename = str::slug($request->title) . '.' . $image->getClientOriginalExtension(); // Nama file baru berdasarkan title
            $image->storeAs($path, $filename, 'public'); // Simpan gambar ke storage

            // Update field image
            $about->image = $filename;
            $about->image_alt_text = $filename;
        }

        // Simpan perubahan ke database
        $about->save();

        // Pastikan untuk mengembalikan response JSON agar AJAX dapat menangani validasi dan sukses
        return response()->json(['success' => true, 'message' => 'About updated successfully']);
    }



    public function uploadImage(Request $request)
    {
        $request->validate([
            'image' => 'image|mimes:jpeg,png,jpg|max:2048',  // Validasi gambar
        ]);

        $image = $request->file('image');
        $imageName = 'content-' . time() . '.' . $image->getClientOriginalExtension();
        $imagePath = 'back/images/about/content/' . $imageName;

        // Simpan gambar ke storage
        Storage::disk('public')->put($imagePath, file_get_contents($image));

        // Kembalikan URL gambar
        return response()->json(['location' => asset('storage/' . $imagePath)]);
    }


    public function deleteImage(Request $request)
    {
        $request->validate([
            'imageUrl' => 'string',
        ]);

        $imageUrl = $request->input('imageUrl');
        $imagePath = parse_url($imageUrl, PHP_URL_PATH);

        // Hapus bagian '/storage/' dari path untuk mendapatkan relative path gambar
        $relativePath = str_replace('/storage/', '', $imagePath);

        // Cek apakah gambar ada di storage
        if (Storage::disk('public')->exists($relativePath)) {
            // Hapus gambar dari storage
            Storage::disk('public')->delete($relativePath);

            return response()->json(['success' => true]);
        }

        return response()->json(['success' => false, 'message' => 'Gambar tidak ditemukan']);
    }
}
