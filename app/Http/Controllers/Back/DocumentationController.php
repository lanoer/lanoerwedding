<?php

namespace App\Http\Controllers\Back;

use App\Http\Controllers\Controller;
use App\Models\Album;
use App\Models\Foto;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Intervention\Image\Facades\Image;

class DocumentationController extends Controller
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
        $albums = Album::all();

        return view('back.pages.documentation.index', [
            'albums' => $albums,
        ]);
    }

    public function addFoto()
    {
        $albums = Album::all();
        return view('back.pages.documentation.add-foto', [
            'albums' => $albums,
        ]);
    }
    public function StoreFoto(Request $request)
    {

        $request->validate([
            'album_id' => 'required|exists:albums,id',
            'image.*' => 'required|image|mimes:jpeg,png,jpg,|max:5000',
        ], [
            'album_id.required' => 'Album harus diisi',
            'album_id.exists' => 'Album tidak ditemukan',
            'image.*.required' => 'Foto harus diisi',
            'image.*.image' => 'Foto harus berupa gambar',
            'image.*.mimes' => 'Foto harus berupa gambar JPG, JPEG, PNG',
            'image.*.max' => 'Foto harus berukuran maksimal 5MB',
        ]);

        if ($request->hasFile('image')) {
            $insert = [];
            foreach ($request->file('image') as $key => $file) {
                $path = 'back/images/album/foto/';
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
                $insert[$key]['album_id'] = $request->album_id;
            }
            Foto::insert($insert);
        }

        activity()
            ->causedBy(auth()->user())
            ->log('Created foto');

        return response()->json(['success' => 'Foto berhasil disimpan']);
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
}
