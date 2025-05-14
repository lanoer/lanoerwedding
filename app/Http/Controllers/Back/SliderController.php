<?php

namespace App\Http\Controllers\Back;

use App\Http\Controllers\Controller;
use App\Models\Slider;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Intervention\Image\Facades\Image;

class SliderController extends Controller
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
        $sliders = Slider::all();
        return view('back.pages.slider.index', compact('sliders'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return view('back.pages.slider.create');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $request->validate([
            'category' => 'required',
            'title' => 'required',
            'desc_short' => 'required',
            'action_link' => 'required|url',
            'action_text' => 'required',
            'image' => 'required|image|mimes:jpeg,png,jpg|max:2048',
        ], [
            'category.required' => 'Category harus diisi',
            'title.required' => 'Title harus diisi',
            'desc_short.required' => 'Description Short harus diisi',
            'action_link.required' => 'Action Link harus diisi',
            'action_text.required' => 'Action Text harus diisi',
            'image.required' => 'Foto harus diisi',
            'image.image' => 'Foto harus berupa gambar',
            'image.mimes' => 'Foto harus berupa gambar JPG, JPEG, PNG',
            'image.max' => 'Foto harus berukuran maksimal 2MB',
        ]);

        if ($request->hasFile('image')) {
            $file = $request->file('image');
            $path = 'back/images/slider/';
            $filename = $file->getClientOriginalName();
            $new_filename = time() . '' . $filename;

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
            Slider::create([
                'image' => $new_filename,
                'title' => $request->title,
                'category' => $request->category,
                'desc_short' => $request->desc_short,
                'desc_long' => $request->desc_long,
                'action_link' => $request->action_link,
                'action_text' => $request->action_text,
            ]);
        }

        return redirect()->route('slider.index')->with('success', 'Slider berhasil disimpan');
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
        $slider = Slider::find($id);
        return view('back.pages.slider.edit', compact('slider'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        $slider = Slider::find($id);

        // Validate only the fields that are present in the request
        $validationRules = [];
        $validationMessages = [];

        if ($request->has('category')) {
            $validationMessages['category.required'] = 'Category harus diisi';
        }

        if ($request->hasFile('image')) {
            $validationRules['image'] = 'image|mimes:jpeg,png,jpg|max:2048';
            $validationMessages['image.image'] = 'Image harus berupa gambar';
            $validationMessages['image.mimes'] = 'Image harus berupa gambar JPG, JPEG, PNG';
            $validationMessages['image.max'] = 'Image harus berukuran maksimal 2MB';
        }

        $request->validate($validationRules, $validationMessages);

        // Update name if provided
        if ($request->has('category')) {
            $slider->category = $request->category;
        }

        // Update image if provided
        if ($request->hasFile('image')) {
            $path = 'back/images/slider/';

            // Delete old images
            if ($slider->image) {
                // Delete original image
                Storage::disk('public')->delete($path . $slider->image);

                // Delete thumbnails
                Storage::disk('public')->delete($path . 'thumbnails/thumb_75_' . $slider->image);
                Storage::disk('public')->delete($path . 'thumbnails/thumb_271_' . $slider->image);
                Storage::disk('public')->delete($path . 'thumbnails/thumb_' . $slider->image);
            }

            $filename = $request->file('image')->getClientOriginalName();
            $new_filename = 'slider-' . time() . '' . $filename;

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

            $slider->image = $new_filename;
        }

        // Update description if provided
        if ($request->has('desc_long')) {
            $slider->desc_long = $request->desc_long;
        }

        if ($request->has('desc_short')) {
            $slider->desc_short = $request->desc_short;
        }

        if ($request->has('action_link')) {
            $slider->action_link = $request->action_link;
        }

        if ($request->has('action_text')) {
            $slider->action_text = $request->action_text;
        }

        if ($request->has('title')) {
            $slider->title = $request->title;
        }


        $slider->save();

        return redirect()->route('slider.index')->with('success', 'Slider updated successfully');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        //
    }
}
