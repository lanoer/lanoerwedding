<?php

namespace App\Http\Controllers\Back;

use App\Http\Controllers\Controller;
use App\Models\WeddingMakeups;
use App\Models\Weddings;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Intervention\Image\Facades\Image;
use Illuminate\Support\Str;

class WeddingController extends Controller
{
    public function __construct()
    {
        $this->middleware('can:read content');
    }
    public function index()
    {
        $weddingMakeups = WeddingMakeups::withCount('weddings')->first();
        return view('back.pages.wedding.weddingmakeup.index', compact('weddingMakeups'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        abort(404);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        abort(404);
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        $weddingMakeups = WeddingMakeups::find($id);
        $weddings = Weddings::where('wedding_makeups_id', $id)->get();
        return view('back.pages.wedding.weddingmakeup.show', compact('weddingMakeups', 'weddings'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit($id)
    {
        $weddingMakeups = WeddingMakeups::find($id);
        return view('back.pages.wedding.weddingmakeup.edit', compact('weddingMakeups'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, $id)
    {
        $weddingMakeups = WeddingMakeups::find($id);

        // Validate only the fields that are present in the request
        $validationRules = [];
        $validationMessages = [];

        if ($request->has('name')) {
            $validationRules['name'] = 'required|unique:wedding_makeups,name,' . $id;
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
            $weddingMakeups->name = $request->name;
        }

        // Update image if provided
        if ($request->hasFile('image')) {
            $path = 'back/images/wedding/weddingmakeup/';

            // Delete old images
            if ($weddingMakeups->image) {
                // Delete original image
                Storage::disk('public')->delete($path . $weddingMakeups->image);

                // Delete thumbnails
                Storage::disk('public')->delete($path . 'thumbnails/thumb_75_' . $weddingMakeups->image);
                Storage::disk('public')->delete($path . 'thumbnails/thumb_271_' . $weddingMakeups->image);
                Storage::disk('public')->delete($path . 'thumbnails/thumb_' . $weddingMakeups->image);
            }

            $filename = $request->file('image')->getClientOriginalName();
            $new_filename = 'weddingmakeup-' . time() . '' . $filename;

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

            $weddingMakeups->image = $new_filename;
        }

        // Update description if provided
        if ($request->has('description')) {
            $weddingMakeups->description = $request->description;
        }

        $weddingMakeups->save();

        activity()
            ->causedBy(auth()->user())
            ->log('Updated wedding makeup');

        return redirect()->route('makeup.list')->with('success', 'Wedding Makeup updated successfully');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        abort(404);
    }


    public function createWedding()
    {
        $weddingMakeups = WeddingMakeups::all();
        $weddings = Weddings::all();
        return view('back.pages.wedding.weddingmakeup.create', compact('weddingMakeups', 'weddings'));
    }

    public function storeWedding(Request $request)
    {
        $request->validate(
            [
                'name' => 'required|unique:weddings,name',
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
                'image.required' => 'Gambar harus diisi',
                'image.mimes' => 'Gambar harus berupa gambar JPG, JPEG, PNG',
                'image.max' => 'Gambar harus berukuran maksimal 2MB',
                'description.required' => 'Deskripsi harus diisi',
                'meta_description.required' => 'Meta deskripsi harus diisi',
                'meta_keywords.required' => 'Meta keywords harus diisi',
                'meta_tags.required' => 'Meta tags harus diisi',
            ]
        );

        $weddingMakeups = new Weddings();
        $weddingMakeups->wedding_makeups_id = $request->wedding_makeups_id;
        $weddingMakeups->name = $request->name;
        $weddingMakeups->slug = Str::slug($request->name); // Generate slug from name
        $weddingMakeups->description = $request->description;
        $weddingMakeups->meta_description = $request->meta_description;
        $weddingMakeups->meta_keywords = $request->meta_keywords;
        $weddingMakeups->meta_tags = $request->meta_tags;

        // Jika ada gambar yang di-upload
        if ($request->hasFile('image')) {
            $path = 'back/images/wedding/weddingmakeup/';

            // Gunakan slug dari name untuk nama file
            $slug = str::slug($request->name); // Ambil slug dari nama wedding
            $extension = $request->file('image')->getClientOriginalExtension(); // Mendapatkan ekstensi file
            $new_filename = $slug . '.' . $extension;  // Nama file baru hanya berdasarkan slug dan ekstensi file

            // Simpan file ukuran asli
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

            $weddingMakeups->image = $new_filename; // Update nama file gambar
            $weddingMakeups->image_alt_text = $new_filename; // Menyimpan alt text gambar
        }

        $weddingMakeups->save(); // Simpan data ke database

        activity()
            ->causedBy(auth()->user())
            ->log('Created wedding makeup');

        return redirect()->route('wedding.main.show', ['id' => $weddingMakeups->wedding_makeups_id])->with('success', 'Wedding Makeup created successfully');
    }


    public function editWedding($id)
    {
        $weddingMakeups = WeddingMakeups::all();
        $weddings = Weddings::find($id);
        return view('back.pages.wedding.weddingmakeup.editmakeup', compact('weddingMakeups', 'weddings'));
    }

    public function updateWedding(Request $request, $id)
    {
        $weddingMakeups = Weddings::find($id);

        // Validate only the fields that are present in the request
        $validationRules = [];
        $validationMessages = [];

        if ($request->has('name')) {
            $validationRules['name'] = 'required|unique:weddings,name,' . $id;
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
            $weddingMakeups->name = $request->name;
            $weddingMakeups->slug = Str::slug($request->name); // Generate slug from name
        }

        // Update image if provided
        if ($request->hasFile('image')) {
            $path = 'back/images/wedding/weddingmakeup/';

            // Delete old images
            if ($weddingMakeups->image) {
                // Delete original image
                Storage::disk('public')->delete($path . $weddingMakeups->image);

                // Delete thumbnails
                Storage::disk('public')->delete($path . 'thumbnails/thumb_75_' . $weddingMakeups->image);
                Storage::disk('public')->delete($path . 'thumbnails/thumb_271_' . $weddingMakeups->image);
                Storage::disk('public')->delete($path . 'thumbnails/thumb_' . $weddingMakeups->image);
            }

            // Gunakan slug dari database untuk nama file
            $slug = $weddingMakeups->slug;  // Ambil slug dari database
            $extension = $request->file('image')->getClientOriginalExtension(); // Mendapatkan ekstensi file
            $new_filename = $slug . '.' . $extension;  // Nama file baru hanya berdasarkan slug

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

            // Update model with new image name and alt text
            $weddingMakeups->image = $new_filename;
            $weddingMakeups->image_alt_text = $new_filename;
        }

        // Update description if provided
        if ($request->has('description')) {
            $weddingMakeups->description = $request->description;
        }
        if ($request->has('meta_description')) {
            $weddingMakeups->meta_description = $request->meta_description;
        }
        if ($request->has('meta_keywords')) {
            $weddingMakeups->meta_keywords = $request->meta_keywords;
        }
        if ($request->has('meta_tags')) {
            $weddingMakeups->meta_tags = $request->meta_tags;
        }

        $weddingMakeups->save();

        activity()
            ->causedBy(auth()->user())
            ->log('Updated wedding makeup');

        return redirect()->route('wedding.main.show', ['id' => $weddingMakeups->wedding_makeups_id])->with('success', 'Wedding Makeup updated successfully');
    }



    public function destroyWedding($id)
    {
        $weddingMakeups = WeddingMakeups::find($id);
        $weddingMakeups->delete();
    }

    public function uploadImage(Request $request)
    {
        $request->validate([
            'image' => 'image|mimes:jpeg,png,jpg|max:2048',  // Validasi gambar
        ]);

        $image = $request->file('image');
        $imageName = 'content-' . time() . '.' . $image->getClientOriginalExtension();
        $imagePath = 'back/images/wedding/weddingmakeup/content/' . $imageName;

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
