<?php

namespace App\Http\Controllers\Back;

use App\Http\Controllers\Controller;
use App\Models\FotoGallery;
use App\Models\GalleryFoto;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;
use Intervention\Image\Facades\Image;

class GalleryController extends Controller
{
    public function __construct()
    {
        $this->middleware('can:read content');
    }
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $gallery = GalleryFoto::all();
        return view('back.pages.gallery.index', compact('gallery'));
    }
    public function addFotoGallery()
    {
        $gallerys = GalleryFoto::all();
        return view('back.pages.gallery.add-foto', [
            'gallerys' => $gallerys,
        ]);
    }
    public function storeFotoGallery(Request $request)
    {
        $request->validate([
            'gallery_fotos_id' => 'required|exists:gallery_fotos,id',
            'image.*' => 'required|image|mimes:jpeg,png,jpg|max:5000',
        ], [
            'gallery_fotos_id.required' => 'Gallery harus diisi',
            'gallery_fotos_id.exists' => 'Gallery tidak ditemukan',
            'image.*.required' => 'Foto harus diisi',
            'image.*.image' => 'Foto harus berupa gambar',
            'image.*.mimes' => 'Foto harus berupa gambar JPG, JPEG, PNG',
            'image.*.max' => 'Foto harus berukuran maksimal 5MB',
        ]);
        $Gallery = GalleryFoto::find($request->gallery_fotos_id);
        // Cek apakah album sudah memiliki 10 foto

        if ($Gallery->FotoGallery()->count() >= 10) {
            return response()->json(['error' => 'Gallery sudah mencapai batas maksimal foto (10 foto)'], 422);
        }
        // Cek apakah album sudah memiliki 10 foto
        if ($request->hasFile('image')) {
            $insert = [];
            foreach ($request->file('image') as $key => $file) {
                $path = 'back/images/gallery/foto/';
                $filename = $file->getClientOriginalName();
                $new_filename = time() . '' . $filename;

                // Simpan file ukuran asli
                $upload = Storage::disk('public')->put($path . $new_filename, (string) file_get_contents($file));

                // Buat dan simpan thumbnail
                $post_thumbnails_path = $path . 'thumbnails';
                if (!Storage::disk('public')->exists($post_thumbnails_path)) {
                    Storage::disk('public')->makeDirectory($post_thumbnails_path, 0755, true, true);
                }
                Image::make(storage_path('app/public/' . $path . $new_filename))
                    ->fit(75, 75)->save(storage_path('app/public/' . $post_thumbnails_path . '/thumb_75_' . $new_filename));

                Image::make(storage_path('app/public/' . $path . $new_filename))
                    ->fit(271, 266)->save(storage_path('app/public/' . $post_thumbnails_path . '/thumb_271_' . $new_filename));

                Image::make(storage_path('app/public/' . $path . $new_filename))
                    ->fit(800, 600)->save(storage_path('app/public/' . $path . 'thumbnails/' . 'thumb_' . $new_filename));

                $insert[$key]['image'] = $new_filename;
                $insert[$key]['title'] = $filename;
                $insert[$key]['gallery_fotos_id'] = $request->gallery_fotos_id;
            }
            FotoGallery::insert($insert);
        }

        activity()
            ->causedBy(auth()->user())
            ->log('Created foto gallery');

        return response()->json(['success' => 'Foto gallery berhasil disimpan']);
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        //
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        //
    }

    public function storeGallery(Request $request)
    {

        $request->validate([
            'gallery_name' => 'required',
            'image' => 'nullable|mimes:jpeg,png,jpg|max:2048',
        ], [
            'gallery_name.required' => 'Nama gallery wajib di isi',
            'gallery_name.unique' => 'Nama gallery sudah ada',
            'image.mimes' => 'Gambar harus berupa jpeg, png, atau jpg',
            'image.max' => 'Gambar harus kurang dari 2MB',
        ]);

        $gallery = new GalleryFoto();
        $gallery->gallery_name = $request->gallery_name;

        if ($request->hasFile('image')) {
            $path = 'back/images/gallery/original/';
            $file = $request->file('image');
            $filename = $file->getClientOriginalName();
            $new_filename = time() . '_' . $filename;
            $upload = Storage::disk('public')->put($path . $new_filename, (string) file_get_contents($file));

            // Buat thumbnail
            $thumbnail_path = 'back/images/gallery/thumbnail/';
            if (!Storage::disk('public')->exists($thumbnail_path)) {
                Storage::disk('public')->makeDirectory($thumbnail_path, 0755, true, true);
            }
            Image::make(storage_path('app/public/' . $path . $new_filename))
                ->fit(520, 400, function ($constraint) {
                    $constraint->upsize();
                })->save(storage_path('app/public/' . $thumbnail_path . $new_filename));

            if ($upload) {
                $gallery->image = $new_filename;
            }
        }
        // dd($album);
        $gallery->save();

        activity()
            ->causedBy(Auth::user())
            ->log('Created gallery ' . $gallery->gallery_name);

        return redirect()->back()->with('success', 'New Gallery has been successfully added.');
    }

    public function updateGallery(Request $request, $id)
    {
        $gallery = GalleryFoto::findOrFail($id);

        $request->validate([
            'gallery_name' => 'required|unique:gallery_fotos,gallery_name,' . $gallery->id,
            'image' => 'nullable|mimes:jpeg,png,jpg|max:2048',
        ], [
            'gallery_name.required' => 'Nama gallery wajib di isi',
            'gallery_name.unique' => 'Nama gallery sudah ada',
            'image.mimes' => 'Gambar harus berupa jpeg, png, atau jpg',
            'image.max' => 'Gambar harus kurang dari 2MB',
        ]);

        $gallery->gallery_name = $request->gallery_name;

        if ($request->hasFile('image')) {
            // Mendefinisikan path untuk gambar gallery
            $thumbnail_path = 'back/images/gallery/thumbnails/';
            $original_path = 'back/images/gallery/';

            // Hapus gambar lama jika ada
            if ($gallery->image && Storage::disk('public')->exists($thumbnail_path . $gallery->image)) {
                Storage::disk('public')->delete($thumbnail_path . $gallery->image);
            }
            if ($gallery->image && Storage::disk('public')->exists($original_path . $gallery->image)) {
                Storage::disk('public')->delete($original_path . $gallery->image);
            }

            // Mendapatkan file gambar yang baru
            $file = $request->file('image');
            $imageName = 'gallery-' . time() . '-' . $file->getClientOriginalName();
            $imagePath = 'back/images/gallery/' . $imageName;

            // Simpan gambar original gallery
            Storage::disk('public')->put($imagePath, file_get_contents($file));

            // Simpan thumbnail untuk gambar gallery
            $thumbPath = 'back/images/gallery/thumbnails/thumb_800_' . $imageName;
            $img = Image::make($file->getRealPath())->fit(800, 600);
            Storage::disk('public')->put($thumbPath, (string) $img->encode());

            // Jika upload berhasil, simpan nama file gambar ke dalam database
            $gallery->image = $imageName;
        }


        $gallery->save();

        activity()
            ->causedBy(Auth::user())
            ->log('Updated gallery ' . $gallery->gallery_name);

        return redirect()->back()->with('success', 'Gallery has been successfully updated.');
    }
}
