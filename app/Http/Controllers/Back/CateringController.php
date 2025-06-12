<?php

namespace App\Http\Controllers\Back;

use App\Http\Controllers\Controller;
use App\Models\CateringPackages;
use App\Models\MediumCatering;
use App\Models\MediumCateringImage;
use App\Models\PremiumCatering;
use App\Models\PremiumCateringImage;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Storage;
use Intervention\Image\Facades\Image;
use Illuminate\Support\Str;

class CateringController extends Controller
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
                'name' => 'required|unique:sound_systems,name',
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
                'image.mimes' => 'Gambar harus berupa gambar JPG, JPEG, PNG',
                'image.max' => 'Gambar harus berukuran maksimal 2MB',
                'image.required' => 'Gambar harus diisi',
                'description.required' => 'Deskripsi harus diisi',
                'meta_description.required' => 'Meta Deskripsi harus diisi',
                'meta_keywords.required' => 'Meta Keywords harus diisi',
            ]
        );

        $catering = new CateringPackages();
        $catering->name = $request->name;
        $catering->description = $request->description;
        $catering->meta_description = $request->meta_description;
        $catering->meta_keywords = $request->meta_keywords;
        $catering->meta_tags = $request->meta_tags;

        if ($request->hasFile('image')) {
            $path = 'back/images/catering/';

            $slug = str::slug($request->name); // Ambil slug dari nama wedding
            $extension = $request->file('image')->getClientOriginalExtension(); // Mendapatkan ekstensi file
            $new_filename = $slug . '.' . $extension;

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
            $catering->image_alt_text = $new_filename;
        }

        $catering->save();

        activity()
            ->causedBy(auth()->user())
            ->log('Created catering');

        return redirect()->route('catering.index')->with('success', 'Catering created successfully');
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

            $slug = str::slug($request->name); // Ambil slug dari nama wedding
            $extension = $request->file('image')->getClientOriginalExtension(); // Mendapatkan ekstensi file
            $new_filename = $slug . '.' . $extension;

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
            $catering->image_alt_text = $new_filename;
        }

        // Update description if provided
        if ($request->has('description')) {
            $catering->description = $request->description;
        }
        if ($request->has('meta_description')) {
            $catering->meta_description = $request->meta_description;
        }
        if ($request->has('meta_keywords')) {
            $catering->meta_keywords = $request->meta_keywords;
        }
        if ($request->has('meta_tags')) {
            $catering->meta_tags = $request->meta_tags;
        }

        $catering->save();

        activity()
            ->causedBy(auth()->user())
            ->log('Updated catering');

        return redirect()->route('catering.index')->with('success', 'Catering updated successfully');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        abort(404);
    }

    public function uploadImage(Request $request)
    {
        $request->validate([
            'image' => 'image|mimes:jpeg,png,jpg|max:2048',  // Validasi gambar
        ]);

        $image = $request->file('image');
        $imageName = 'content-' . time() . '.' . $image->getClientOriginalExtension();
        $imagePath = 'back/images/catering/content/' . $imageName;

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


    public function editMediumCatering($id)
    {
        $mediums = MediumCatering::with('images')->find($id);
        return view('back.pages.catering.edit-medium', compact('mediums'));
    }

    public function updateMediumCatering(Request $request, string $id)
    {
        // Cek jika decoration ada
        $mediums = MediumCatering::findOrFail($id);

        // Validasi input
        $request->validate([
            'name' => 'nullable|string|max:255|unique:decorations,name,' . $id,
            'description' => 'nullable|string',
            'main_image' => 'nullable|image|mimes:jpeg,png,jpg|max:2048',
            'gallery.*' => 'nullable|image|mimes:jpeg,png,jpg|max:2048',
            'meta_description' => 'nullable|string',
            'meta_keywords' => 'nullable|string',
            'meta_tags' => 'nullable|string',
        ]);

        // Update properti yang dikirim dalam request
        if ($request->has('name')) {
            $mediums->name = $request->name;

            // Update slug jika nama berubah
            $mediums->slug = Str::slug($request->name);  // Atau bisa pakai $decoration->slug = $decoration->generateSlug();
        }

        if ($request->has('description')) {
            $mediums->description = $request->description;
        }

        if ($request->has('meta_description')) {
            $mediums->meta_description = $request->meta_description;
        }

        if ($request->has('meta_keywords')) {
            $mediums->meta_keywords = $request->meta_keywords;
        }

        if ($request->has('meta_tags')) {
            $mediums->meta_tags = $request->meta_tags;
        }

        // Update gambar utama jika ada file gambar yang diupload
        if ($request->hasFile('main_image')) {
            $mainImage = $request->file('main_image');
            $mainImageName = 'mediums-main-' . time() . '-' . $mainImage->getClientOriginalName();
            $mainImagePath = 'back/images/catering/medium/' . $mainImageName;

            // Hapus gambar lama jika ada
            if ($mediums->image) {
                Storage::disk('public')->delete('back/images/catering/medium/' . $mediums->image);
                Storage::disk('public')->delete('back/images/catering/medium/thumbnails/thumb_800_' . $mediums->image);
            }

            // Simpan gambar baru dan buat thumbnail
            Storage::disk('public')->put($mainImagePath, file_get_contents($mainImage));
            $thumbPath = 'back/images/catering/medium/thumbnails/thumb_800_' . $mainImageName;
            $img = Image::make($mainImage->getRealPath())->fit(800, 600);
            Storage::disk('public')->put($thumbPath, (string) $img->encode());

            $mediums->image = $mainImageName;
            $mediums->image_alt_text = $mainImageName;
        }

        // Simpan perubahan
        $mediums->save();

        // Simpan gambar galeri baru jika ada
        if ($request->hasFile('gallery')) {
            foreach ($request->file('gallery') as $file) {
                $galleryImageName = 'catering-gallery-' . time() . '-' . $file->getClientOriginalName();
                $galleryImagePath = 'back/images/catering/medium/gallery/' . $galleryImageName;

                Storage::disk('public')->put($galleryImagePath, file_get_contents($file));
                $galleryThumbPath = 'back/images/catering/medium/gallery/thumbnails/thumb_800_' . $galleryImageName;
                $img = Image::make($file->getRealPath())->fit(800, 400);
                Storage::disk('public')->put($galleryThumbPath, (string) $img->encode());

                MediumCateringImage::create([
                    'medium_caterings_id' => $mediums->id,
                    'image' => $galleryImageName,
                ]);
            }
        }

        // Log aktivitas
        activity()->causedBy(auth()->user())->log('Updated Catering Medium: ' . $mediums->name);

        return response()->json(['success' => 'Catering medium berhasil diperbarui']);
    }

    public function deleteGalleryImageMedium($id)
    {
        $image = MediumCateringImage::find($id);

        Log::info('Deleting image: ' . $image->image);
        Storage::disk('public')->delete('back/images/catering/medium/gallery/' . $image->image);
        Storage::disk('public')->delete('back/images/catering/medium/gallery/thumbnails/thumb_800_/' . $image->image);
        $image->delete();

        return response()->json(['success' => 'Image deleted']);
    }

    public function uploadImageMedium(Request $request)
    {
        $request->validate([
            'image' => 'image|mimes:jpeg,png,jpg|max:2048',  // Validasi gambar
        ]);

        $image = $request->file('image');
        $imageName = 'content-' . time() . '.' . $image->getClientOriginalExtension();
        $imagePath = 'back/images/catering/medium/content/' . $imageName;

        // Simpan gambar ke storage
        Storage::disk('public')->put($imagePath, file_get_contents($image));

        // Kembalikan URL gambar
        return response()->json(['location' => asset('storage/' . $imagePath)]);
    }


    public function deleteImageMedium(Request $request)
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
    public function editPremiumCatering($id)
    {
        $premiums = PremiumCatering::with('images')->findOrFail($id);
        return view('back.pages.catering.edit-premium', compact('premiums'));
    }

    public function updatePremiumCatering(Request $request, string $id)
    {
        // Cek jika decoration ada
        $premiums = PremiumCatering::findOrFail($id);

        // Validasi input
        $request->validate([
            'name' => 'nullable|string|max:255|unique:decorations,name,' . $id,
            'description' => 'nullable|string',
            'main_image' => 'nullable|image|mimes:jpeg,png,jpg|max:2048',
            'gallery.*' => 'nullable|image|mimes:jpeg,png,jpg|max:2048',
            'meta_description' => 'nullable|string',
            'meta_keywords' => 'nullable|string',
            'meta_tags' => 'nullable|string',
        ]);

        // Update properti yang dikirim dalam request
        if ($request->has('name')) {
            $premiums->name = $request->name;

            // Update slug jika nama berubah
            $premiums->slug = Str::slug($request->name);  // Atau bisa pakai $decoration->slug = $decoration->generateSlug();
        }

        if ($request->has('description')) {
            $premiums->description = $request->description;
        }

        if ($request->has('meta_description')) {
            $premiums->meta_description = $request->meta_description;
        }

        if ($request->has('meta_keywords')) {
            $premiums->meta_keywords = $request->meta_keywords;
        }

        if ($request->has('meta_tags')) {
            $premiums->meta_tags = $request->meta_tags;
        }

        // Update gambar utama jika ada file gambar yang diupload
        if ($request->hasFile('main_image')) {
            $mainImage = $request->file('main_image');
            $mainImageName = 'premiums-main-' . time() . '-' . $mainImage->getClientOriginalName();
            $mainImagePath = 'back/images/catering/premium/' . $mainImageName;

            // Hapus gambar lama jika ada
            if ($premiums->image) {
                Storage::disk('public')->delete('back/images/decoration/' . $premiums->image);
                Storage::disk('public')->delete('back/images/decoration/thumbnails/thumb_800_' . $premiums->image);
            }

            // Simpan gambar baru dan buat thumbnail
            Storage::disk('public')->put($mainImagePath, file_get_contents($mainImage));
            $thumbPath = 'back/images/decoration/thumbnails/thumb_800_' . $mainImageName;
            $img = Image::make($mainImage->getRealPath())->fit(800, 600);
            Storage::disk('public')->put($thumbPath, (string) $img->encode());

            $premiums->image = $mainImageName;
            $premiums->image_alt_text = $mainImageName;
        }

        // Simpan perubahan
        $premiums->save();

        // Simpan gambar galeri baru jika ada
        if ($request->hasFile('gallery')) {
            foreach ($request->file('gallery') as $file) {
                $galleryImageName = 'catering-gallery-' . time() . '-' . $file->getClientOriginalName();
                $galleryImagePath = 'back/images/catering/premium/gallery/' . $galleryImageName;

                Storage::disk('public')->put($galleryImagePath, file_get_contents($file));
                $galleryThumbPath = 'back/images/catering/premium/gallery/thumbnails/thumb_800_' . $galleryImageName;
                $img = Image::make($file->getRealPath())->fit(800, 400);
                Storage::disk('public')->put($galleryThumbPath, (string) $img->encode());

                PremiumCateringImage::create([
                    'premium_caterings_id' => $premiums->id,
                    'image' => $galleryImageName,
                ]);
            }
        }

        // Log aktivitas
        activity()->causedBy(auth()->user())->log('Updated Catering Premium: ' . $premiums->name);

        return response()->json(['success' => 'Catering premium berhasil diperbarui']);
    }

    public function deleteGalleryImage($id)
    {
        $image = PremiumCateringImage::find($id);
        if (!$image) {
            // Tambahkan log agar tahu ID berapa yang error
            \Log::error("PremiumCatering ID {$id} tidak ditemukan.");
            abort(404, 'Premium Catering tidak ditemukan.');
        }

        Log::info('Deleting image: ' . $image->image);
        Storage::disk('public')->delete('back/images/catering/premium/gallery/' . $image->image);
        Storage::disk('public')->delete('back/images/catering/premium/gallery/thumbnails/thumb_800_/' . $image->image);
        $image->delete();

        return response()->json(['success' => 'Image deleted']);
    }

    public function uploadImagePremium(Request $request)
    {
        $request->validate([
            'image' => 'image|mimes:jpeg,png,jpg|max:2048',  // Validasi gambar
        ]);

        $image = $request->file('image');
        $imageName = 'content-' . time() . '.' . $image->getClientOriginalExtension();
        $imagePath = 'back/images/catering/premium/content/' . $imageName;

        // Simpan gambar ke storage
        Storage::disk('public')->put($imagePath, file_get_contents($image));

        // Kembalikan URL gambar
        return response()->json(['location' => asset('storage/' . $imagePath)]);
    }


    public function deleteImagePremium(Request $request)
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
