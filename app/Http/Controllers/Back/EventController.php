<?php

namespace App\Http\Controllers\Back;

use App\Http\Controllers\Controller;
use App\Models\Event;
use App\Models\EventMakeups;
use App\Models\WeddingMakeups;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Intervention\Image\Facades\Image;

class EventController extends Controller
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

        $eventMakeups = new Event();
        $eventMakeups->event_makeups_id = $request->event_makeups_id;
        $eventMakeups->name = $request->name;
        $eventMakeups->description = $request->description;

        if ($request->hasFile('image')) {
            $path = 'back/images/event/eventmakeup/';

            $filename = $request->file('image')->getClientOriginalName();
            $new_filename = 'eventmakeup-' . time() . '' . $filename;

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

            $eventMakeups->image = $new_filename;
        }

        $eventMakeups->save();

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

            // Create thumbnails with different sizes
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

        return redirect()->route('event.main.show', ['id' => $eventMakeups->event_makeups_id])->with('success', 'Event Makeup updated successfully');
    }

    public function destroyMakeup($id)
    {
        $eventMakeups = Event::find($id);
        $eventMakeups->delete();
    }
}
