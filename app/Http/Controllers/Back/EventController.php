<?php

namespace App\Http\Controllers\Back;

use App\Http\Controllers\Controller;
use App\Models\Event;
use App\Models\EventMakeups;
use App\Models\WeddingMakeups;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Intervention\Image\Facades\Image;
use Illuminate\Support\Str;

class EventController extends Controller
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
        $eventMakeups = EventMakeups::withCount('events')->first();
        $weddingMakeups = WeddingMakeups::withCount('weddings')->first();
        return view('back.pages.event.eventmakeup.index', compact('eventMakeups', 'weddingMakeups'));
    }


    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        $eventMakeups = EventMakeups::find($id);
        $events = Event::where('event_makeups_id', $id)->get();
        return view('back.pages.event.eventmakeup.show', compact('eventMakeups', 'events'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit($id)
    {
        $eventMakeups = EventMakeups::find($id);
        return view('back.pages.event.eventmakeup.edit', compact('eventMakeups'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, $id)
    {
        $eventMakeups = EventMakeups::find($id);

        // Validate only the fields that are present in the request
        $validationRules = [];
        $validationMessages = [];

        if ($request->has('name')) {
            $validationRules['name'] = 'required|unique:event_makeups,name,' . $id;
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
            $eventMakeups->name = $request->name;
        }

        // Update image if provided
        if ($request->hasFile('image')) {
            $path = 'back/images/event/eventmakeup/';

            // Delete old images
            if ($eventMakeups->image) {
                // Delete original image
                Storage::disk('public')->delete($path . $eventMakeups->image);

                // Delete thumbnails
                Storage::disk('public')->delete($path . 'thumbnails/thumb_75_' . $eventMakeups->image);
                Storage::disk('public')->delete($path . 'thumbnails/thumb_271_' . $eventMakeups->image);
                Storage::disk('public')->delete($path . 'thumbnails/thumb_' . $eventMakeups->image);
            }

            $filename = $request->file('image')->getClientOriginalName();
            $new_filename = 'eventmakeup-' . time() . '' . $filename;

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

            $eventMakeups->image = $new_filename;
        }

        // Update description if provided
        if ($request->has('description')) {
            $eventMakeups->description = $request->description;
        }

        $eventMakeups->save();

        activity()
            ->causedBy(auth()->user())
            ->log('Updated event makeup');

        return redirect()->route('makeup.list')->with('success', 'Event Makeup updated successfully');
    }


    public function createMakeup()
    {
        $eventMakeups = EventMakeups::all();
        $events = Event::all();
        return view('back.pages.event.eventmakeup.create', compact('eventMakeups', 'events'));
    }

    public function storeMakeup(Request $request)
    {
        $request->validate(
            [
                'name' => 'required|unique:event_makeups,name',
                'image' => 'required|image|mimes:jpeg,png,jpg|max:2048',
                'description' => 'required|string',
                'meta_description' => 'required|string',
                'meta_keywords' => 'required|string',
                'meta_tags' => 'required|string',

            ],
            [
                'name.required' => 'Nama harus diisi',
                'name.unique' => 'Nama sudah ada',
                'image.image' => 'Gambar harus berupa gambar',
                'image.mimes' => 'Gambar harus berupa gambar JPG, JPEG, PNG',
                'image.required' => 'Gambar harus diisi',
                'image.max' => 'Gambar harus berukuran maksimal 2MB',
                'description.required' => 'Deskripsi harus diisi',
                'meta_description.required' => 'Meta deskripsi harus diisi',
                'meta_keywords.required' => 'Meta kata kunci harus diisi',
                'meta_tags.required' => 'Meta tag harus diisi',
            ]
        );

        $eventMakeups = new Event();
        $eventMakeups->event_makeups_id = $request->event_makeups_id;
        $eventMakeups->name = $request->name;
        $eventMakeups->slug = Str::slug($request->name);
        $eventMakeups->description = $request->description;
        $eventMakeups->meta_description = $request->meta_description;
        $eventMakeups->meta_keywords = $request->meta_keywords;
        $eventMakeups->meta_tags = $request->meta_tags;

        if ($request->hasFile('image')) {
            $path = 'back/images/event/eventmakeup/';

            $slug = str::slug($request->name);
            $extension = $request->file('image')->getClientOriginalExtension();
            $new_filename = $slug . '.' . $extension;

            $upload = Storage::disk('public')->put($path . $new_filename, (string) file_get_contents($request->file('image')));

            // Buat dan simpan thumbnail
            $post_thumbnails_path = $path . 'thumbnails';
            if (!Storage::disk('public')->exists($post_thumbnails_path)) {
                Storage::disk('public')->makeDirectory($post_thumbnails_path, 0755, true, true);
            }


            Image::make(storage_path('app/public/' . $path . $new_filename))
                ->fit(271, 266)->save(storage_path('app/public/' . $post_thumbnails_path . '/thumb_271_' . $new_filename));

            Image::make(storage_path('app/public/' . $path . $new_filename))
                ->fit(800, 600)->save(storage_path('app/public/' . $path . 'thumbnails/' . 'thumb_' . $new_filename));

            $eventMakeups->image = $new_filename;
            $eventMakeups->image_alt_text = $new_filename;
        }

        $eventMakeups->save();

        activity()
            ->causedBy(auth()->user())
            ->log('Created event makeup');

        return redirect()->route('event.main.show', ['id' => 1])->with('success', 'Event Makeup created successfully');
    }

    public function editMakeup($id)
    {
        $eventMakeups = Event::find($id);
        $event = EventMakeups::all();
        return view('back.pages.event.eventmakeup.editmakeup', compact('eventMakeups', 'event'));
    }

    public function updateMakeup(Request $request, $id)
    {
        $eventMakeups = Event::find($id);

        // Validate only the fields that are present in the request
        $validationRules = [];
        $validationMessages = [];

        if ($request->has('name')) {
            $validationRules['name'] = 'required|unique:events,name,' . $id;
            $validationMessages['name.required'] = 'Nama harus diisi';
            $validationMessages['name.unique'] = 'Nama sudah ada';
        }

        if ($request->hasFile('image')) {
            $validationRules['image'] = 'image|mimes:jpeg,png,jpg|max:2048';
            $validationMessages['image.image'] = 'Gambar harus berupa gambar';
            $validationMessages['image.mimes'] = 'Gambar harus berupa gambar JPG, JPEG, PNG';
            $validationMessages['image.max'] = 'Gambar harus berukuran maksimal 2MB';
        }

        $request->validate($validationRules, $validationMessages);

        // Update name if provided
        if ($request->has('name')) {
            $eventMakeups->name = $request->name;
        }

        // Set the slug from the name (fallback)
        $eventMakeups->slug = Str::slug($request->name); // Ensure slug is set before image filename generation

        // Update other fields
        if ($request->has('description')) {
            $eventMakeups->description = $request->description;
        }

        if ($request->has('meta_description')) {
            $eventMakeups->meta_description = $request->meta_description;
        }
        if ($request->has('meta_keywords')) {
            $eventMakeups->meta_keywords = $request->meta_keywords;
        }
        if ($request->has('meta_tags')) {
            $eventMakeups->meta_tags = $request->meta_tags;
        }

        // Update image if provided
        if ($request->hasFile('image')) {
            $path = 'back/images/event/eventmakeup/';

            // Delete old images if they exist
            if ($eventMakeups->image) {
                Storage::disk('public')->delete($path . $eventMakeups->image);
                Storage::disk('public')->delete($path . 'thumbnails/thumb_75_' . $eventMakeups->image);
                Storage::disk('public')->delete($path . 'thumbnails/thumb_271_' . $eventMakeups->image);
                Storage::disk('public')->delete($path . 'thumbnails/thumb_' . $eventMakeups->image);
            }

            // Ensure slug is correctly used for image name
            $slug = Str::slug($request->name);  // Use the slug created from the name

            $extension = $request->file('image')->getClientOriginalExtension();
            $new_filename = $slug . '.' . $extension;

            // Save the image file with the new filename
            Storage::disk('public')->put($path . $new_filename, (string) file_get_contents($request->file('image')));

            // Create and save thumbnails
            $post_thumbnails_path = $path . 'thumbnails';
            if (!Storage::disk('public')->exists($post_thumbnails_path)) {
                Storage::disk('public')->makeDirectory($post_thumbnails_path, 0755, true, true);
            }

            // Create thumbnail images
            Image::make(storage_path('app/public/' . $path . $new_filename))
                ->fit(271, 266)->save(storage_path('app/public/' . $post_thumbnails_path . '/thumb_271_' . $new_filename));

            Image::make(storage_path('app/public/' . $path . $new_filename))
                ->fit(800, 600)->save(storage_path('app/public/' . $path . 'thumbnails/' . 'thumb_' . $new_filename));

            // Set the image and alt text
            $eventMakeups->image = $new_filename;
            $eventMakeups->image_alt_text = $new_filename;
        }

        $eventMakeups->save();

        activity()
            ->causedBy(auth()->user())
            ->log('Updated event makeup');

        return redirect()->route('event.main.show', ['id' => $eventMakeups->event_makeups_id])->with('success', 'Event Makeup updated successfully');
    }



    public function destroyMakeup($id)
    {
        $eventMakeups = Event::find($id);
        $eventMakeups->delete();
    }

    public function uploadImage(Request $request)
    {
        $request->validate([
            'image' => 'image|mimes:jpeg,png,jpg|max:2048',  // Validasi gambar
        ]);

        $image = $request->file('image');
        $imageName = 'content-' . time() . '.' . $image->getClientOriginalExtension();
        $imagePath = 'back/images/event/eventmakeup/content/' . $imageName;

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
