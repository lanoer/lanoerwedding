<?php

namespace App\Http\Controllers\back;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Album;
use Illuminate\Support\Facades\Storage;
use Intervention\Image\Facades\Image;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Log;

class AlbumController extends Controller
{
    public function store(Request $request)
    {
        Log::info('Masuk ke AlbumController@store');

        $request->validate([
            'album_name' => 'required',
            'image' => 'nullable|mimes:jpeg,png,jpg|max:2048',
        ], [
            'album_name.required' => 'Nama album wajib di isi',
            'album_name.unique' => 'Nama album sudah ada',
            'image.mimes' => 'Gambar harus berupa jpeg, png, atau jpg',
            'image.max' => 'Gambar harus kurang dari 2MB',
        ]);

        $album = new Album();
        $album->album_name = $request->album_name;

        if ($request->hasFile('image')) {
            $path = 'back/images/album/original/';
            $file = $request->file('image');
            $filename = $file->getClientOriginalName();
            $new_filename = time() . '_' . $filename;
            $upload = Storage::disk('public')->put($path . $new_filename, (string) file_get_contents($file));

            // Buat thumbnail
            $thumbnail_path = 'back/images/album/thumbnail/';
            if (!Storage::disk('public')->exists($thumbnail_path)) {
                Storage::disk('public')->makeDirectory($thumbnail_path, 0755, true, true);
            }
            Image::make(storage_path('app/public/' . $path . $new_filename))
                ->fit(520, 400, function ($constraint) {
                    $constraint->upsize();
                })->save(storage_path('app/public/' . $thumbnail_path . $new_filename));

            if ($upload) {
                $album->image = $new_filename;
            }
        }
        // dd($album);
        $album->save();

        activity()
            ->causedBy(Auth::user())
            ->log('Created album ' . $album->album_name);

        return redirect()->back()->with('success', 'New Album has been successfully added.');
    }

    public function update(Request $request, $id)
    {
        $album = Album::findOrFail($id);

        $request->validate([
            'album_name' => 'required|unique:albums,album_name,' . $album->id,
            'image' => 'nullable|mimes:jpeg,png,jpg|max:2048',
        ], [
            'album_name.required' => 'Nama album wajib di isi',
            'album_name.unique' => 'Nama album sudah ada',
            'image.mimes' => 'Gambar harus berupa jpeg, png, atau jpg',
            'image.max' => 'Gambar harus kurang dari 2MB',
        ]);

        $album->album_name = $request->album_name;

        if ($request->hasFile('image')) {
            // Hapus file lama jika ada
            $thumbnail_path = 'back/images/album/thumbnail/';
            $original_path = 'back/images/album/original/';
            if ($album->image && Storage::disk('public')->exists($thumbnail_path . $album->image)) {
                Storage::disk('public')->delete($thumbnail_path . $album->image);
            }
            if ($album->image && Storage::disk('public')->exists($original_path . $album->image)) {
                Storage::disk('public')->delete($original_path . $album->image);
            }

            $file = $request->file('image');
            $filename = $file->getClientOriginalName();
            $new_filename = time() . '_' . $filename;
            $upload = Storage::disk('public')->put($original_path . $new_filename, (string) file_get_contents($file));

            // Buat thumbnail
            if (!Storage::disk('public')->exists($thumbnail_path)) {
                Storage::disk('public')->makeDirectory($thumbnail_path, 0755, true, true);
            }
            Image::make(storage_path('app/public/' . $original_path . $new_filename))
                ->fit(520, 400, function ($constraint) {
                    $constraint->upsize();
                })->save(storage_path('app/public/' . $thumbnail_path . $new_filename));

            if ($upload) {
                $album->image = $new_filename;
            }
        }

        $album->save();

        activity()
            ->causedBy(Auth::user())
            ->log('Updated album ' . $album->album_name);

        return redirect()->back()->with('success', 'Album has been successfully updated.');
    }
}
