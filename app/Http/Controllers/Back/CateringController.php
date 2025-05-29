<?php

namespace App\Http\Controllers\Back;

use App\Http\Controllers\Controller;
use App\Models\CateringPackages;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Intervention\Image\Facades\Image;

class CateringController extends Controller
{

    /**
     * Display a listing of the resource.
     */

    public function __construct()
    {
        $this->middleware('can:read pages');
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
                'name' => 'required|unique:catering_packages,name',
                'image' => 'image|mimes:jpeg,png,jpg|max:2048',
            ],
            [
                'name.required' => 'Nama harus diisi',
                'name.unique' => 'Nama sudah ada',
                'image.image' => 'Gambar harus berupa gambar',
                'image.mimes' => 'Gambar harus berupa gambar JPG, JPEG, PNG',
                'image.max' => 'Gambar harus berukuran maksimal 2MB',
            ]
        );

        $catering = new CateringPackages();
        $catering->name = $request->name;
        $catering->description = $request->description;

        if ($request->hasFile('image')) {
            $path = 'back/images/catering/';

            $filename = $request->file('image')->getClientOriginalName();
            $new_filename = 'catering-' . time() . '' . $filename;

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
        }

        $catering->save();

        return redirect()->route('catering.index')->with('success', 'Catering created successfully');
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

            $filename = $request->file('image')->getClientOriginalName();
            $new_filename = 'catering-' . time() . '' . $filename;

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
        }

        // Update description if provided
        if ($request->has('description')) {
            $catering->description = $request->description;
        }

        $catering->save();

        return redirect()->route('catering.index')->with('success', 'Catering updated successfully');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        //
    }
}
