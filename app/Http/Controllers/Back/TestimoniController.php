<?php

namespace App\Http\Controllers\Back;

use App\Http\Controllers\Controller;
use App\Models\Testimonial;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Intervention\Image\Facades\Image;

class TestimoniController extends Controller
{

    public function __construct()
    {
        $this->middleware('can:read pages');
    }

    public function index()
    {
        $testimonials = Testimonial::all();
        return view('back.pages.testimoni.index', compact('testimonials'));
    }

    public function create()
    {
        return view('back.pages.testimoni.create');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required',
            'testimoni' => 'required',
            'image' => 'image|mimes:jpeg,png,jpg|max:2048',
        ], [
            'name.required' => 'Name harus diisi',
            'testimoni.required' => 'Testimoni harus diisi',
            'image.image' => 'Foto harus berupa gambar',
            'image.mimes' => 'Foto harus berupa gambar JPG, JPEG, PNG',
            'image.max' => 'Foto harus berukuran maksimal 2MB',
        ]);

        if ($request->hasFile('image')) {
            $file = $request->file('image');
            $path = 'back/images/testimoni/';
            $filename = $file->getClientOriginalName();
            $new_filename = 'testimoni-' . time() . '' . $filename;

            // Simpan file ukuran asli
            Storage::disk('public')->put($path . $new_filename, (string) file_get_contents($file));

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

            // Create new slider record
            Testimonial::create([
                'image' => $new_filename,
                'name' => $request->name,
                'testimoni' => $request->testimoni,
                'rating' => $request->rating,
            ]);
        }

        return redirect()->route('testimoni.index')->with('success', 'Testimoni berhasil disimpan');
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
    public function edit($id)
    {
        $testimoni = Testimonial::find($id);
        return view('back.pages.testimoni.edit', compact('testimoni'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        $testimoni = Testimonial::find($id);

        // Validate only the fields that are present in the request
        $validationRules = [];
        $validationMessages = [];

        if ($request->has('name')) {
            $validationRules['name'] = 'required';
            $validationMessages['name.required'] = 'Name harus diisi';
            $validationMessages['name.unique'] = 'Name sudah ada';
        }

        if ($request->hasFile('image')) {
            $validationRules['image'] = 'image|mimes:jpeg,png,jpg|max:2048';
            $validationMessages['image.image'] = 'Image harus berupa gambar';
            $validationMessages['image.mimes'] = 'Image harus berupa gambar JPG, JPEG, PNG';
            $validationMessages['image.max'] = 'Image harus berukuran maksimal 2MB';
        }

        if ($request->has('testimoni')) {
            $validationRules['testimoni'] = 'required';
            $validationMessages['testimoni.required'] = 'Testimoni harus diisi';
        }

        $request->validate($validationRules, $validationMessages);

        // Update name if provided
        if ($request->has('name')) {
            $testimoni->name = $request->name;
        }

        // Update image if provided
        if ($request->hasFile('image')) {
            $path = 'back/images/testimoni/';

            // Delete old images
            if ($testimoni->image) {
                // Delete original image
                Storage::disk('public')->delete($path . $testimoni->image);

                // Delete thumbnails
                Storage::disk('public')->delete($path . 'thumbnails/thumb_75_' . $testimoni->image);
                Storage::disk('public')->delete($path . 'thumbnails/thumb_271_' . $testimoni->image);
                Storage::disk('public')->delete($path . 'thumbnails/thumb_' . $testimoni->image);
            }

            $filename = $request->file('image')->getClientOriginalName();
            $new_filename = 'testimoni-' . time() . '' . $filename;

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

            $testimoni->image = $new_filename;
        }

        // Update description if provided
        if ($request->has('testimoni')) {
            $testimoni->testimoni = $request->testimoni;
        }

        $testimoni->save();

        return redirect()->route('testimoni.index')->with('success', 'Testimoni updated successfully');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        //
    }
}
