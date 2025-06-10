<?php

namespace App\Http\Controllers\Back;

use App\Http\Controllers\Controller;
use App\Models\CateringPackages;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Intervention\Image\Facades\Image;
use Illuminate\Support\Str;

class CateringController extends Controller
{

    /**
     * Display a listing of the resource.
     */

    public function __construct()
    {
        $this->middleware('can:read content');
    }
    public function index()
    {
        return view('back.pages.catering.index');
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {

        return view('back.pages.catering.create');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $request->validate(
            [
                'name' => 'required|unique:sound_systems,name',
                'image' => 'required|image|mimes:jpeg,png,jpg|max:2048',
                'description' => 'required',
                'meta_description' => 'required',
                'meta_keywords' => 'required',
                'meta_tags' => 'required',
            ],
            [
                'name.required' => 'Nama harus diisi',
                'name.unique' => 'Nama sudah ada',
                'image.image' => 'Gambar harus berupa gambar',
                'image.mimes' => 'Gambar harus berupa gambar JPG, JPEG, PNG',
                'image.max' => 'Gambar harus berukuran maksimal 2MB',
                'image.required' => 'Gambar harus diisi',
                'description.required' => 'Deskripsi harus diisi',
                'meta_description.required' => 'Meta Deskripsi harus diisi',
                'meta_keywords.required' => 'Meta Keywords harus diisi',
            ]
        );

        $catering = new CateringPackages();
        $catering->name = $request->name;
        $catering->description = $request->description;
        $catering->meta_description = $request->meta_description;
        $catering->meta_keywords = $request->meta_keywords;
        $catering->meta_tags = $request->meta_tags;

        if ($request->hasFile('image')) {
            $path = 'back/images/catering/';

            $slug = str::slug($request->name); // Ambil slug dari nama wedding
            $extension = $request->file('image')->getClientOriginalExtension(); // Mendapatkan ekstensi file
            $new_filename = $slug . '.' . $extension;

            // Simpan file ukuran asli
            $upload = Storage::disk('public')->put($path . $new_filename, (string) file_get_contents($request->file('image')));

            // Buat dan simpan thumbnail
            $post_thumbnails_path = $path . 'thumbnails';
            if (!Storage::disk('public')->exists($post_thumbnails_path)) {
                Storage::disk('public')->makeDirectory($post_thumbnails_path, 0755, true, true);
            }

            // Create thumbnails with different sizes
            Image::make(storage_path('app/public/' . $path . $new_filename))
                ->fit(75, 75)->save(storage_path('app/public/' . $post_thumbnails_path . '/thumb_75_' . $new_filename));

            Image::make(storage_path('app/public/' . $path . $new_filename))
                ->fit(271, 266)->save(storage_path('app/public/' . $post_thumbnails_path . '/thumb_271_' . $new_filename));

            Image::make(storage_path('app/public/' . $path . $new_filename))
                ->fit(800, 600)->save(storage_path('app/public/' . $path . 'thumbnails/' . 'thumb_' . $new_filename));

            $catering->image = $new_filename;
            $catering->image_alt_text = $new_filename;
        }

        $catering->save();

        activity()
            ->causedBy(auth()->user())
            ->log('Created catering');

        return redirect()->route('catering.index')->with('success', 'Catering created successfully');
    }


    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        abort(404);
    }

    /**
     * Show the form for editing the specified resource.
     */

    public function edit($id)
    {
        $catering = CateringPackages::find($id);
        return view('back.pages.catering.edit', compact('catering'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        $catering = CateringPackages::find($id);

        // Validate only the fields that are present in the request
        $validationRules = [];
        $validationMessages = [];

        if ($request->has('name')) {
            $validationRules['name'] = 'required|unique:catering_packages,name,' . $id;
            $validationMessages['name.required'] = 'Name harus diisi';
            $validationMessages['name.unique'] = 'Name sudah ada';
        }

        if ($request->hasFile('image')) {
            $validationRules['image'] = 'image|mimes:jpeg,png,jpg|max:2048';
            $validationMessages['image.image'] = 'Image harus berupa gambar';
            $validationMessages['image.mimes'] = 'Image harus berupa gambar JPG, JPEG, PNG';
            $validationMessages['image.max'] = 'Image harus berukuran maksimal 2MB';
        }

        $request->validate($validationRules, $validationMessages);

        // Update name if provided
        if ($request->has('name')) {
            $catering->name = $request->name;
        }

        // Update image if provided
        if ($request->hasFile('image')) {
            $path = 'back/images/catering/';

            // Delete old images
            if ($catering->image) {
                // Delete original image
                Storage::disk('public')->delete($path . $catering->image);

                // Delete thumbnails
                Storage::disk('public')->delete($path . 'thumbnails/thumb_75_' . $catering->image);
                Storage::disk('public')->delete($path . 'thumbnails/thumb_271_' . $catering->image);
                Storage::disk('public')->delete($path . 'thumbnails/thumb_' . $catering->image);
            }

            $slug = str::slug($request->name); // Ambil slug dari nama wedding
            $extension = $request->file('image')->getClientOriginalExtension(); // Mendapatkan ekstensi file
            $new_filename = $slug . '.' . $extension;

            // Simpan file ukuran asli
            $upload = Storage::disk('public')->put($path . $new_filename, (string) file_get_contents($request->file('image')));

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

            $catering->image = $new_filename;
            $catering->image_alt_text = $new_filename;
        }

        // Update description if provided
        if ($request->has('description')) {
            $catering->description = $request->description;
        }
        if ($request->has('meta_description')) {
            $catering->meta_description = $request->meta_description;
        }
        if ($request->has('meta_keywords')) {
            $catering->meta_keywords = $request->meta_keywords;
        }
        if ($request->has('meta_tags')) {
            $catering->meta_tags = $request->meta_tags;
        }

        $catering->save();

        activity()
            ->causedBy(auth()->user())
            ->log('Updated catering');

        return redirect()->route('catering.index')->with('success', 'Catering updated successfully');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        abort(404);
    }

    public function uploadImage(Request $request)
    {
        $request->validate([
            'image' => 'image|mimes:jpeg,png,jpg|max:2048',  // Validasi gambar
        ]);

        $image = $request->file('image');
        $imageName = 'content-' . time() . '.' . $image->getClientOriginalExtension();
        $imagePath = 'back/images/catering/content/' . $imageName;

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
