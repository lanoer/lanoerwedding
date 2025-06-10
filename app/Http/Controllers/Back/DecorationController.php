<?php

namespace App\Http\Controllers\Back;

use App\Http\Controllers\Controller;
use App\Models\Decorations;
use App\Models\DecorationImage;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Intervention\Image\Facades\Image;
use Spatie\MediaLibrary\MediaCollections\Models\Media;

class DecorationController extends Controller
{

    public function __construct()
    {
        $this->middleware('can:read content');
    }

    public function index()
    {
        return view('back.pages.decoration.index');
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return view('back.pages.decoration.create');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'description' => 'required|string',
            'main_image' => 'required|image|mimes:jpeg,png,jpg|max:2048',
            'gallery.*' => 'image|mimes:jpeg,png,jpg|max:2048',
            'meta_description' => 'required',
            'meta_keywords' => 'required',
            'meta_tags' => 'required',
        ], [
            'name.required' => 'Name harus diisi',
            'name.string' => 'Name harus berupa string',
            'name.max' => 'Name maksimal 255 karakter',
            'description.required' => 'Description harus diisi',
            'description.string' => 'Description harus berupa string',
            'main_image.required' => 'image utama harus diisi',
            'main_image.image' => 'image utama harus berupa gambar',
            'main_image.mimes' => 'image utama harus berupa gambar JPG, JPEG, PNG',
            'main_image.max' => 'image utama harus berukuran maksimal 2MB',
            'gallery.*.image' => 'image gallery harus berupa gambar',
            'gallery.*.mimes' => 'image gallery harus berupa gambar JPG, JPEG, PNG',
            'gallery.*.max' => 'image gallery harus berukuran maksimal 2MB',
            'meta_description.required' => 'Meta description harus diisi',
            'meta_keywords.required' => 'Meta keywords harus diisi',
            'meta_tags.required' => 'Meta tags harus diisi',
        ]
    );

        // Simpan main image
        $mainImageName = null;
        if ($request->hasFile('main_image')) {
            $mainImage = $request->file('main_image');
            $mainImageName = 'decoration-main-' . time() . '-' . $mainImage->getClientOriginalName();
            $mainImagePath = 'back/images/decoration/' . $mainImageName;

            // Simpan original
            Storage::disk('public')->put($mainImagePath, file_get_contents($mainImage));

            // Simpan thumbnail
            $thumbPath = 'back/images/decoration/thumbnails/thumb_271_' . $mainImageName;
            $img = Image::make($mainImage->getRealPath())->fit(271, 266);
            Storage::disk('public')->put($thumbPath, (string) $img->encode());
        }

        // Simpan data decoration
        $decoration = new Decorations();
        $decoration->name = $request->name;
        $decoration->description = $request->description;
        $decoration->image = $mainImageName;
        $decoration->meta_description = $request->meta_description;
        $decoration->meta_keywords = $request->meta_keywords;
        $decoration->meta_tags = $request->meta_tags;
        $decoration->image_alt_text = $mainImageName;
        $decoration->save();

        // Simpan multiple images (gallery)
        if ($request->hasFile('gallery')) {
            foreach ($request->file('gallery') as $file) {
                $galleryImageName = 'decoration-gallery-' . time() . '-' . $file->getClientOriginalName();
                $galleryImagePath = 'back/images/decoration/gallery/' . $galleryImageName;

                // Simpan original
                Storage::disk('public')->put($galleryImagePath, file_get_contents($file));

                // Simpan thumbnail
                $galleryThumbPath = 'back/images/decoration/gallery/thumbnails/thumb_271_' . $galleryImageName;
                $img = Image::make($file->getRealPath())->fit(271, 266);
                Storage::disk('public')->put($galleryThumbPath, (string) $img->encode());

                // Simpan ke tabel decoration_images
                DecorationImage::create([
                    'decoration_id' => $decoration->id,
                    'image' => $galleryImageName,
                ]);
            }
        }

        activity()
            ->causedBy(auth()->user())
            ->log('Created decoration');

        return response()->json(['success' => 'Decoration berhasil disimpan']);
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
        $decoration = Decorations::with('images')->find($id);
        return view('back.pages.decoration.edit', compact('decoration'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        $decoration = Decorations::find($id);

        $request->validate(
            [
                'name' => 'required|string|max:255|unique:decorations,name,' . $id,
                'description' => 'required|string',
                'main_image' => 'nullable|image|mimes:jpeg,png,jpg|max:2048',
                'gallery.*' => 'image|mimes:jpeg,png,jpg|max:2048',
                'meta_description' => 'required',
                'meta_keywords' => 'required',
                'meta_tags' => 'required',
            ],
            [
                'name.required' => 'Name harus diisi',
                'name.string' => 'Name harus berupa string',
                'name.max' => 'Name maksimal 255 karakter',
                'description.required' => 'Description harus diisi',
                'description.string' => 'Description harus berupa string',
                'main_image.required' => 'image utama harus diisi',
                'main_image.image' => 'image utama harus berupa gambar',
                'main_image.mimes' => 'image utama harus berupa gambar JPG, JPEG, PNG',
                'main_image.max' => 'image utama harus berukuran maksimal 2MB',
                'gallery.*.image' => 'image gallery harus berupa gambar',
                'gallery.*.mimes' => 'image gallery harus berupa gambar JPG, JPEG, PNG',
                'gallery.*.max' => 'image gallery harus berukuran maksimal 2MB',
                'meta_description.required' => 'Meta description harus diisi',
                'meta_keywords.required' => 'Meta keywords harus diisi',
                'meta_tags.required' => 'Meta tags harus diisi',
            ]
        );

        $decoration->name = $request->name;
        $decoration->description = $request->description;

        $decoration->meta_description = $request->meta_description;
        $decoration->meta_keywords = $request->meta_keywords;
        $decoration->meta_tags = $request->meta_tags;

        // Update main image jika ada
        if ($request->hasFile('main_image')) {
            $mainImage = $request->file('main_image');
            $mainImageName = 'decoration-main-' . time() . '-' . $mainImage->getClientOriginalName();
            $mainImagePath = 'back/images/decoration/' . $mainImageName;

            // Hapus gambar lama
            if ($decoration->image) {
                Storage::disk('public')->delete('back/images/decoration/' . $decoration->image);
                Storage::disk('public')->delete('back/images/decoration/thumbnails/thumb_271_' . $decoration->image);
            }

            Storage::disk('public')->put($mainImagePath, file_get_contents($mainImage));
            $thumbPath = 'back/images/decoration/thumbnails/thumb_271_' . $mainImageName;
            $img = Image::make($mainImage->getRealPath())->fit(271, 266);
            Storage::disk('public')->put($thumbPath, (string) $img->encode());

            $decoration->image = $mainImageName;
            $decoration->image_alt_text = $mainImageName;
        }

        $decoration->save();

        // Simpan gallery baru jika ada
        if ($request->hasFile('gallery')) {
            foreach ($request->file('gallery') as $file) {
                $galleryImageName = 'decoration-gallery-' . time() . '-' . $file->getClientOriginalName();
                $galleryImagePath = 'back/images/decoration/gallery/' . $galleryImageName;

                Storage::disk('public')->put($galleryImagePath, file_get_contents($file));
                $galleryThumbPath = 'back/images/decoration/gallery/thumbnails/thumb_271_' . $galleryImageName;
                $img = Image::make($file->getRealPath())->fit(271, 266);
                Storage::disk('public')->put($galleryThumbPath, (string) $img->encode());

                DecorationImage::create([
                    'decoration_id' => $decoration->id,
                    'image' => $galleryImageName,
                ]);
            }
        }

        activity()
            ->causedBy(auth()->user())
            ->log('Updated decoration');

        return response()->json(['success' => 'Decoration updated successfully']);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        //
    }

    public function deleteGalleryImage($id)
    {
        $image = DecorationImage::findOrFail($id);
        Storage::disk('public')->delete('back/images/decoration/gallery/' . $image->image);
        Storage::disk('public')->delete('back/images/decoration/gallery/thumbnails/thumb_271_' . $image->image);
        $image->delete();

        return response()->json(['success' => 'Image deleted']);
    }

    public function uploadImage(Request $request)
    {
        $request->validate([
            'image' => 'image|mimes:jpeg,png,jpg|max:2048',  // Validasi gambar
        ]);

        $image = $request->file('image');
        $imageName = 'content-' . time() . '.' . $image->getClientOriginalExtension();
        $imagePath = 'back/images/decoration/content/' . $imageName;

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
