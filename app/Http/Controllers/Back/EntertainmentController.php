<?php

namespace App\Http\Controllers\Back;

use App\Http\Controllers\Controller;
use App\Models\Ceremonial;
use App\Models\CeremonialEvent;
use App\Models\Live;
use App\Models\LiveMusic;
use App\Models\Sound;
use App\Models\SoundSystem;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Intervention\Image\Facades\Image;

class EntertainmentController extends Controller
{
    public function __construct()
    {
        $this->middleware('can:read pages');
    }
    public function index()
    {
        return view('back.pages.entertainment.index');
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
        $sound = Sound::find($id);
        $soundSystems = SoundSystem::where('sounds_id', $id)->get();
        return view('back.pages.entertainment.sound.show', compact('sound', 'soundSystems'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        $sound = Sound::find($id);
        return view('back.pages.entertainment.sound.edit', compact('sound'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, $id)
    {
        $sound = Sound::find($id);

        // Validate only the fields that are present in the request
        $validationRules = [];
        $validationMessages = [];

        if ($request->has('name')) {
            $validationRules['name'] = 'required|unique:sounds,name,' . $id;
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
            $sound->name = $request->name;
        }

        // Update image if provided
        if ($request->hasFile('image')) {
            $path = 'back/images/entertainment/sound/';

            // Delete old images
            if ($sound->image) {
                // Delete original image
                Storage::disk('public')->delete($path . $sound->image);

                // Delete thumbnails
                Storage::disk('public')->delete($path . 'thumbnails/thumb_75_' . $sound->image);
                Storage::disk('public')->delete($path . 'thumbnails/thumb_271_' . $sound->image);
                Storage::disk('public')->delete($path . 'thumbnails/thumb_' . $sound->image);
            }

            $filename = $request->file('image')->getClientOriginalName();
            $new_filename = 'sound-' . time() . '' . $filename;

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

            $sound->image = $new_filename;
        }

        // Update description if provided
        if ($request->has('description')) {
            $sound->description = $request->description;
        }

        $sound->save();

        return redirect()->route('entertainment.index')->with('success', 'Sound updated successfully');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        //
    }


    public function createSound()
    {
        $soundsystems = SoundSystem::all();
        $sounds = Sound::all();
        return view('back.pages.entertainment.sound.create', compact('sounds', 'soundsystems'));
    }

    public function storeSound(Request $request)
    {

        $request->validate(
            [
                'name' => 'required|unique:sound_systems,name',
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

        $soundSystem = new SoundSystem();
        $soundSystem->sounds_id = $request->sounds_id;
        $soundSystem->name = $request->name;
        $soundSystem->description = $request->description;

        if ($request->hasFile('image')) {
            $path = 'back/images/entertainment/sound/';

            $filename = $request->file('image')->getClientOriginalName();
            $new_filename = 'sound-' . time() . '' . $filename;

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

            $soundSystem->image = $new_filename;
        }

        $soundSystem->save();

        return redirect()->route('entertainment.sound.show', ['id' => 1])->with('success', 'Sound System created successfully');
    }

    public function editSound(string $id)
    {
        $soundSystem = SoundSystem::find($id);
        $sounds = Sound::all();
        return view('back.pages.entertainment.sound.editSound', compact('soundSystem', 'sounds'));
    }

    public function updateSound(Request $request, $id)
    {
        $soundSystem = SoundSystem::find($id);

        // Validate only the fields that are present in the request
        $validationRules = [];
        $validationMessages = [];

        if ($request->has('name')) {
            $validationRules['name'] = 'required|unique:sound_systems,name,' . $id;
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
            $soundSystem->name = $request->name;
        }

        // Update image if provided
        if ($request->hasFile('image')) {
            $path = 'back/images/entertainment/sound/';

            // Delete old images
            if ($soundSystem->image) {
                // Delete original image
                Storage::disk('public')->delete($path . $soundSystem->image);

                // Delete thumbnails
                Storage::disk('public')->delete($path . 'thumbnails/thumb_75_' . $soundSystem->image);
                Storage::disk('public')->delete($path . 'thumbnails/thumb_271_' . $soundSystem->image);
                Storage::disk('public')->delete($path . 'thumbnails/thumb_' . $soundSystem->image);
            }

            $filename = $request->file('image')->getClientOriginalName();
            $new_filename = 'sound-' . time() . '' . $filename;

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

            $soundSystem->image = $new_filename;
        }

        // Update description if provided
        if ($request->has('description')) {
            $soundSystem->description = $request->description;
        }

        $soundSystem->save();

        return redirect()->route('entertainment.sound.show', ['id' => $soundSystem->sounds_id])->with('success', 'Sound System updated successfully');
    }

    public function editLive(string $id)
    {
        $live = Live::find($id);
        return view('back.pages.entertainment.live.editLive', compact('live'));
    }
    public function updateLive(Request $request, $id)
    {
        $live = Live::find($id);

        // Validate only the fields that are present in the request
        $validationRules = [];
        $validationMessages = [];

        if ($request->has('name')) {
            $validationRules['name'] = 'required|unique:lives,name,' . $id;
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
            $live->name = $request->name;
        }

        // Update image if provided
        if ($request->hasFile('image')) {
            $path = 'back/images/entertainment/live/';

            // Delete old images
            if ($live->image) {
                // Delete original image
                Storage::disk('public')->delete($path . $live->image);

                // Delete thumbnails
                Storage::disk('public')->delete($path . 'thumbnails/thumb_75_' . $live->image);
                Storage::disk('public')->delete($path . 'thumbnails/thumb_271_' . $live->image);
                Storage::disk('public')->delete($path . 'thumbnails/thumb_' . $live->image);
            }

            $filename = $request->file('image')->getClientOriginalName();
            $new_filename = 'live-' . time() . '' . $filename;

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

            $live->image = $new_filename;
        }

        // Update description if provided
        if ($request->has('description')) {
            $live->description = $request->description;
        }

        $live->save();

        return redirect()->route('entertainment.index')->with('success', 'Live Music updated successfully');
    }

    public function showLive(string $id)
    {
        $live = Live::find($id);
        $liveMusic = LiveMusic::where('lives_id', $id)->get();
        return view('back.pages.entertainment.live.showLive', compact('live', 'liveMusic'));
    }

    public function createLive()
    {
        $lives = Live::all();
        $liveMusic = LiveMusic::all();
        return view('back.pages.entertainment.live.createLive', compact('lives', 'liveMusic'));
    }

    public function storeLive(Request $request)
    {

        $request->validate(
            [
                'name' => 'required|unique:live_music,name',
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

        $liveMusic = new LiveMusic();
        $liveMusic->lives_id = $request->lives_id;
        $liveMusic->name = $request->name;
        $liveMusic->description = $request->description;

        if ($request->hasFile('image')) {
            $path = 'back/images/entertainment/live/';

            $filename = $request->file('image')->getClientOriginalName();
            $new_filename = 'live-' . time() . '' . $filename;

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

            $liveMusic->image = $new_filename;
        }

        $liveMusic->save();

        return redirect()->route('entertainment.live.show', ['id' => 1])->with('success', 'Live Music created successfully');
    }

    public function editLiveMusic(string $id)
    {
        $liveMusic = LiveMusic::find($id);
        $lives = Live::all();
        return view('back.pages.entertainment.live.editLiveMusic', compact('liveMusic', 'lives'));
    }

    public function updateLiveMusic(Request $request, $id)
    {
        $liveMusic = LiveMusic::find($id);

        // Validate only the fields that are present in the request
        $validationRules = [];
        $validationMessages = [];

        if ($request->has('name')) {
            $validationRules['name'] = 'required|unique:live_music,name,' . $id;
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
            $liveMusic->name = $request->name;
        }

        // Update image if provided
        if ($request->hasFile('image')) {
            $path = 'back/images/entertainment/live/';

            // Delete old images
            if ($liveMusic->image) {
                // Delete original image
                Storage::disk('public')->delete($path . $liveMusic->image);

                // Delete thumbnails
                Storage::disk('public')->delete($path . 'thumbnails/thumb_75_' . $liveMusic->image);
                Storage::disk('public')->delete($path . 'thumbnails/thumb_271_' . $liveMusic->image);
                Storage::disk('public')->delete($path . 'thumbnails/thumb_' . $liveMusic->image);
            }

            $filename = $request->file('image')->getClientOriginalName();
            $new_filename = 'live-' . time() . '' . $filename;

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

            $liveMusic->image = $new_filename;
        }

        // Update description if provided
        if ($request->has('description')) {
            $liveMusic->description = $request->description;
        }

        $liveMusic->save();

        return redirect()->route('entertainment.live.show', ['id' => $liveMusic->lives_id])->with('success', 'Live Music updated successfully');
    }


    public function editCeremonial(string $id)
    {
        $ceremonial = Ceremonial::find($id);
        return view('back.pages.entertainment.ceremonial.editCeremonial', compact('ceremonial'));
    }

    public function updateCeremonial(Request $request, $id)
    {
        $ceremonial = Ceremonial::find($id);

        // Validate only the fields that are present in the request
        $validationRules = [];
        $validationMessages = [];

        if ($request->has('name')) {
            $validationRules['name'] = 'required|unique:ceremonials,name,' . $id;
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
            $ceremonial->name = $request->name;
        }

        // Update image if provided
        if ($request->hasFile('image')) {
            $path = 'back/images/entertainment/ceremonial/';

            // Delete old images
            if ($ceremonial->image) {
                // Delete original image
                Storage::disk('public')->delete($path . $ceremonial->image);

                // Delete thumbnails
                Storage::disk('public')->delete($path . 'thumbnails/thumb_75_' . $ceremonial->image);
                Storage::disk('public')->delete($path . 'thumbnails/thumb_271_' . $ceremonial->image);
                Storage::disk('public')->delete($path . 'thumbnails/thumb_' . $ceremonial->image);
            }

            $filename = $request->file('image')->getClientOriginalName();
            $new_filename = 'ceremonial-' . time() . '' . $filename;

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

            $ceremonial->image = $new_filename;
        }

        // Update description if provided
        if ($request->has('description')) {
            $ceremonial->description = $request->description;
        }

        $ceremonial->save();

        return redirect()->route('entertainment.index')->with('success', 'Ceremonial updated successfully');
    }

    public function showCeremonial(string $id)
    {
        $ceremonial = Ceremonial::find($id);
        $ceremonialEvent = CeremonialEvent::where('ceremonial_id', $id)->get();
        return view('back.pages.entertainment.ceremonial.showCeremonial', compact('ceremonial', 'ceremonialEvent'));
    }

    public function createCeremonial()
    {
        $ceremonial = Ceremonial::all();
        $ceremonialEvent = CeremonialEvent::all();
        return view('back.pages.entertainment.ceremonial.createCeremonial', compact('ceremonial', 'ceremonialEvent'));
    }
    public function storeCeremonial(Request $request)
    {

        $request->validate(
            [
                'name' => 'required|unique:ceremonial_events,name',
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

        $ceremonialEvent = new CeremonialEvent();
        $ceremonialEvent->ceremonial_id = $request->ceremonial_id;
        $ceremonialEvent->name = $request->name;
        $ceremonialEvent->description = $request->description;

        if ($request->hasFile('image')) {
            $path = 'back/images/entertainment/ceremonial/';

            $filename = $request->file('image')->getClientOriginalName();
            $new_filename = 'ceremonial-' . time() . '' . $filename;

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

            $ceremonialEvent->image = $new_filename;
        }

        $ceremonialEvent->save();

        return redirect()->route('entertainment.ceremonial.show', ['id' => 1])->with('success', 'Ceremonial created successfully');
    }


    public function editCeremonialEvent(string $id)
    {
        $ceremonialEvent = CeremonialEvent::find($id);
        $ceremonial = Ceremonial::all();
        return view('back.pages.entertainment.ceremonial.editCeremonialEvent', compact('ceremonialEvent', 'ceremonial'));
    }

    public function updateCeremonialEvent(Request $request, $id)
    {
        $ceremonialEvent = CeremonialEvent::find($id);

        // Validate only the fields that are present in the request
        $validationRules = [];
        $validationMessages = [];

        if ($request->has('name')) {
            $validationRules['name'] = 'required|unique:ceremonial_events,name,' . $id;
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
            $ceremonialEvent->name = $request->name;
        }

        // Update image if provided
        if ($request->hasFile('image')) {
            $path = 'back/images/entertainment/ceremonial/';

            // Delete old images
            if ($ceremonialEvent->image) {
                // Delete original image
                Storage::disk('public')->delete($path . $ceremonialEvent->image);

                // Delete thumbnails
                Storage::disk('public')->delete($path . 'thumbnails/thumb_75_' . $ceremonialEvent->image);
                Storage::disk('public')->delete($path . 'thumbnails/thumb_271_' . $ceremonialEvent->image);
                Storage::disk('public')->delete($path . 'thumbnails/thumb_' . $ceremonialEvent->image);
            }

            $filename = $request->file('image')->getClientOriginalName();
            $new_filename = 'ceremonial-' . time() . '' . $filename;

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

            $ceremonialEvent->image = $new_filename;
        }

        // Update description if provided
        if ($request->has('description')) {
            $ceremonialEvent->description = $request->description;
        }

        $ceremonialEvent->save();

        return redirect()->route('entertainment.ceremonial.show', ['id' => $ceremonialEvent->ceremonial_id])->with('success', 'Ceremonial Event updated successfully');
    }
}
