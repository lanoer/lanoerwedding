<?php

namespace App\Http\Controllers\Back;

use App\Http\Controllers\Controller;
use App\Models\TeamLanoer;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Intervention\Image\Facades\Image;

class TeamLanoerController extends Controller
{
    public function __construct()
    {
        $this->middleware('can:read pages');
    }
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        //
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return view('back.pages.team.create');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $request->validate(
            [
                'name' => 'required|unique:team_lanoers,name',
                'image' => 'image|mimes:jpeg,png,jpg|max:6048',
                'position' => 'required',
                'facebook' => 'url',
                'instagram' => 'url',
                'twitter' => 'url',
                'tiktok' => 'url',
            ],
            [
                'name.required' => 'Nama harus diisi',
                'name.unique' => 'Nama sudah ada',
                'image.image' => 'Gambar harus berupa gambar',
                'image.mimes' => 'Gambar harus berupa gambar JPG, JPEG, PNG',
                'image.max' => 'Gambar harus berukuran maksimal 2MB',
                'position.required' => 'Posisi harus diisi',
                'facebook.url' => 'Facebook harus berupa URL',
                'instagram.url' => 'Instagram harus berupa URL',
                'twitter.url' => 'Twitter harus berupa URL',
                'tiktok.url' => 'Tiktok harus berupa URL',
            ]
        );

        $team = new TeamLanoer();
        $team->name = $request->name;
        $team->position = $request->position;
        $team->facebook = $request->facebook;
        $team->instagram = $request->instagram;
        $team->twitter = $request->twitter;
        $team->tiktok = $request->tiktok;

        if ($request->hasFile('image')) {
            $path = 'back/images/team/';

            $filename = $request->file('image')->getClientOriginalName();
            $new_filename = 'team-' . time() . '' . $filename;

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
                ->fit(600, 660)->save(storage_path('app/public/' . $post_thumbnails_path . '/thumb_600_' . $new_filename));

            Image::make(storage_path('app/public/' . $path . $new_filename))
                ->fit(800, 600)->save(storage_path('app/public/' . $path . 'thumbnails/' . 'thumb_' . $new_filename));

            $team->image = $new_filename;
        }

        $team->save();

        return redirect()->route('team.list')->with('success', 'Team Lanoer created successfully');
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
        $team = TeamLanoer::find($id);
        return view('back.pages.team.edit', compact('team'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        $team = TeamLanoer::find($id);

        // Validate only the fields that are present in the request
        $validationRules = [];
        $validationMessages = [];

        if ($request->has('name')) {
            $validationRules['name'] = 'required|unique:team_lanoers,name,' . $id;
            $validationMessages['name.required'] = 'Name harus diisi';
            $validationMessages['name.unique'] = 'Name sudah ada';
        }

        if ($request->hasFile('image')) {
            $validationRules['image'] = 'image|mimes:jpeg,png,jpg|max:2048';
            $validationMessages['image.image'] = 'Image harus berupa gambar';
            $validationMessages['image.mimes'] = 'Image harus berupa gambar JPG, JPEG, PNG';
            $validationMessages['image.max'] = 'Image harus berukuran maksimal 2MB';
        }

        if ($request->has('position')) {
            $validationRules['position'] = 'required';
            $validationMessages['position.required'] = 'Position harus diisi';
        }

        if ($request->has('facebook')) {
            $validationRules['facebook'] = 'url';
            $validationMessages['facebook.url'] = 'Facebook harus berupa URL';
        }

        if ($request->has('instagram')) {
            $validationRules['instagram'] = 'url';
            $validationMessages['instagram.url'] = 'Instagram harus berupa URL';
        }

        if ($request->has('twitter')) {
            $validationRules['twitter'] = 'url';
            $validationMessages['twitter.url'] = 'Twitter harus berupa URL';
        }


        if ($request->has('tiktok')) {
            $validationRules['tiktok'] = 'url';
            $validationMessages['tiktok.url'] = 'Tiktok harus berupa URL';
        }

        $request->validate($validationRules, $validationMessages);

        // Update name if provided
        if ($request->has('name')) {
            $team->name = $request->name;
            $team->facebook = $request->facebook;
            $team->instagram = $request->instagram;
            $team->twitter = $request->twitter;
            $team->tiktok = $request->tiktok;
        }

        // Update image if provided
        if ($request->hasFile('image')) {
            $path = 'back/images/team/';

            // Delete old images
            if ($team->image) {
                // Delete original image
                Storage::disk('public')->delete($path . $team->image);

                // Delete thumbnails
                Storage::disk('public')->delete($path . 'thumbnails/thumb_75_' . $team->image);
                Storage::disk('public')->delete($path . 'thumbnails/thumb_600_' . $team->image);
                Storage::disk('public')->delete($path . 'thumbnails/thumb_' . $team->image);
            }

            $filename = $request->file('image')->getClientOriginalName();
            $new_filename = 'team-' . time() . '' . $filename;

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
                ->fit(600, 660)->save(storage_path('app/public/' . $post_thumbnails_path . '/thumb_600_' . $new_filename));
            Image::make(storage_path('app/public/' . $path . $new_filename))
                ->fit(800, 600)->save(storage_path('app/public/' . $path . 'thumbnails/' . 'thumb_' . $new_filename));

            $team->image = $new_filename;
        }

        // Update description if provided
        if ($request->has('position')) {
            $team->position = $request->position;
        }

        $team->save();

        return redirect()->route('team.list')->with('success', 'Team Lanoer updated successfully');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        //
    }
}
