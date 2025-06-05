<?php

namespace App\Http\Controllers\Back;

use App\Http\Controllers\Controller;
use App\Models\Client;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Intervention\Image\Facades\Image;

class ClientController extends Controller
{
    public function __construct()
     {
         $this->middleware('can:read content');
     }

    public function index()
    {
        $clients = Client::all();
        return view('back.pages.client.index', compact('clients'));
    }

    public function create()
    {
        return view('back.pages.client.create');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required',
            'image' => 'image|mimes:jpeg,png,jpg|max:2048',
        ], [
            'name.required' => 'Name harus diisi',
            'image.image' => 'Foto harus berupa gambar',
            'image.mimes' => 'Foto harus berupa gambar JPG, JPEG, PNG',
            'image.max' => 'Foto harus berukuran maksimal 2MB',
        ]);

        if ($request->hasFile('image')) {
            $file = $request->file('image');
            $path = 'back/images/client/';
            $filename = $file->getClientOriginalName();
            $new_filename = 'client-' . time() . '' . $filename;

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
            Client::create([
                'image' => $new_filename,
                'name' => $request->name,
            ]);
        }

        activity()
            ->causedBy(auth()->user())
            ->log('Created client');

        return redirect()->route('client.index')->with('success', 'Client berhasil disimpan');
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
        $client = Client::find($id);
        return view('back.pages.client.edit', compact('client'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        $client = Client::find($id);

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


        $request->validate($validationRules, $validationMessages);

        // Update name if provided
        if ($request->has('name')) {
            $client->name = $request->name;
        }

        // Update image if provided
        if ($request->hasFile('image')) {
            $path = 'back/images/client/';

            // Delete old images
            if ($client->image) {
                // Delete original image
                Storage::disk('public')->delete($path . $client->image);

                // Delete thumbnails
                Storage::disk('public')->delete($path . 'thumbnails/thumb_75_' . $client->image);
                Storage::disk('public')->delete($path . 'thumbnails/thumb_271_' . $client->image);
                Storage::disk('public')->delete($path . 'thumbnails/thumb_' . $client->image);
            }

            $filename = $request->file('image')->getClientOriginalName();
            $new_filename = 'client-' . time() . '' . $filename;

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

            $client->image = $new_filename;
        }

        // Update description if provided

        $client->save();

        activity()
            ->causedBy(auth()->user())
            ->log('Updated client');

        return redirect()->route('client.index')->with('success', 'Client updated successfully');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        //
    }
}
