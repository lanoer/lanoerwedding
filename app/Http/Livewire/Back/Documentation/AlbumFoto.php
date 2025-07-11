<?php

namespace App\Http\Livewire\Back\Documentation;

use App\Models\Album;
use App\Models\Foto;
use App\Models\Video;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Storage;
use Livewire\Component;
use Livewire\WithFileUploads;
use Livewire\WithPagination;
use Intervention\Image\Facades\Image;

class AlbumFoto extends Component
{
    use WithFileUploads;
    use WithPagination;

    protected $paginationTheme = 'bootstrap';

    public $album_name;

    public $selected_album_id;

    public $updateAlbumMode = false;

    public $perPage = 6;

    public $title;

    public $img;

    public $image;

    public $album_id;

    public $oldImg;

    public $selected_foto_id;

    public $updateFotoMode = false;

    public $album = null;

    public $selectedFotos = [];
    public $Videos = [];
    public $video_name;
    public $video_url;
    public $selected_video_id;
    public $updateVideoMode = false;
    public $perPageVideo = 5;
    public $perPageAlbum = 5;
    public $activeTab = 'albums';

    public $searchAlbum = '';
    public $searchVideo = '';

    public $listeners = [
        'resetModalForm',
        'deleteAlbumAction',
        'updateAlbumOrdering',
        'deleteFotoAction',
        'deleteSelectedFotos',
        'deleteVideoAction',
        'deleteVideo',
        'refresh'
    ];
    public function setActiveTab($tab)
    {
        $this->activeTab = $tab;
    }
    public function resetModalForm()
    {
        $this->resetErrorBag();
        $this->album_name = null;
        $this->img = null;
        $this->title = null;
        $this->oldImg = null;
    }

    // public function addAlbum()
    // {
    //     $this->validate([
    //         'album_name' => 'required|unique:albums,album_name',
    //         'image' => 'nullable|image|max:2048',
    //     ]);

    //     $album = new Album();
    //     $album->album_name = $this->album_name;

    //     if ($this->image) {
    //         $filename = uniqid() . '.' . $this->image->getClientOriginalExtension();

    //         // Simpan original
    //         $this->image->storeAs('back/images/album/original', $filename, 'public');

    //         // Resize dan simpan thumbnail (ini yang dipakai di database)
    //         $resizedImage = Image::make($this->image->getRealPath())
    //             ->fit(520, 400, function ($constraint) {
    //                 $constraint->upsize();
    //             });
    //         $thumbnailDir = storage_path('app/public/back/images/album/thumbnail');
    //         if (!file_exists($thumbnailDir)) {
    //             mkdir($thumbnailDir, 0777, true);
    //         }
    //         $thumbnailPath = $thumbnailDir . '/' . $filename;
    //         $resizedImage->save($thumbnailPath);

    //         // Simpan nama file resize ke database
    //         $album->image = $filename;
    //     }
    //     $saved = $album->save();
    //     // dd($album);

    //     if ($saved) {
    //         $this->dispatchBrowserEvent('hideAlbumModal');
    //         $this->resetModalForm();
    //         flash()->addSuccess('New Album has been successfuly added.');
    //         activity()
    //             ->causedBy(auth()->user())
    //             ->log('Created album ' . $album->album_name);
    //     } else {
    //         flash()->addError('Something went wrong!');
    //     }
    // }

    public function editAlbum($id)
    {
        $album = Album::findOrFail($id);
        $this->selected_album_id = $album->id;
        $this->album_name = $album->album_name;
        $this->updateAlbumMode = true;
        $this->resetErrorBag();
        $this->dispatchBrowserEvent('showalbumModal');
    }

    // public function updateAlbum()
    // {
    //     if ($this->selected_album_id) {
    //         $this->validate([
    //             'album_name' => 'required|unique:albums,album_name,' . $this->selected_album_id,
    //             'image' => 'nullable|image|max:2048',
    //         ]);

    //         $album = Album::findOrFail($this->selected_album_id);
    //         $album->album_name = $this->album_name;

    //         if ($this->image) {
    //             // Hapus file lama jika ada
    //             if ($album->image && \Storage::disk('public')->exists('back/images/album/thumbnail/' . $album->image)) {
    //                 \Storage::disk('public')->delete('back/images/album/thumbnail/' . $album->image);
    //             }
    //             if ($album->image && \Storage::disk('public')->exists('back/images/album/original/' . $album->image)) {
    //                 \Storage::disk('public')->delete('back/images/album/original/' . $album->image);
    //             }

    //             $filename = uniqid() . '.' . $this->image->getClientOriginalExtension();

    //             // Simpan original
    //             $this->image->storeAs('back/images/album/original', $filename, 'public');

    //             // Resize dan simpan thumbnail
    //             $resizedImage = Image::make($this->image->getRealPath())
    //                 ->fit(520, 400, function ($constraint) {
    //                     $constraint->upsize();
    //                 });
    //             $thumbnailDir = storage_path('app/public/back/images/album/thumbnail');
    //             if (!file_exists($thumbnailDir)) {
    //                 mkdir($thumbnailDir, 0777, true);
    //             }
    //             $thumbnailPath = $thumbnailDir . '/' . $filename;
    //             $resizedImage->save($thumbnailPath);

    //             // Simpan nama file resize ke database
    //             $album->image = $filename;
    //         }

    //         $updated = $album->save();
    //         if ($updated) {
    //             $this->dispatchBrowserEvent('hideAlbumModal');
    //             $this->resetModalForm();
    //             flash()->addSuccess('Album has been successfuly updated.');
    //             activity()
    //                 ->causedBy(auth()->user())
    //                 ->log('Updated album ' . $album->album_name);
    //         } else {
    //             flash()->addError('Something went wrong!');
    //         }
    //     }
    // }

    public function deleteAlbum($id)
    {
        $album = Album::find($id);
        $this->dispatchBrowserEvent('deleteAlbum', [
            'title' => 'Are you sure?',
            'html' => 'You want to delete <b>' . $album->album_name . '</b> album',
            'id' => $id,
        ]);
    }

    public function deleteAlbumAction($id)
    {
        $album = Album::where('id', $id)->first();
        $foto = Foto::where('album_id', $album->id)->get()->toArray();
        if (!empty($foto) && count($foto) > 0) {
            flash()->addError('This Album has (' . count($foto) . ') foto related it, cannot be deleted.');
        } else {
            $album->delete();
            flash()->addSuccess('Album has been successfuly deleted.');
            activity()
                ->causedBy(auth()->user())
                ->log('Deleted album ' . $album->album_name);
        }
    }

    public function updateAlbumOrdering($positions)
    {
        foreach ($positions as $p) {
            $index = $p[0];
            $newPosition = $p[1];
            Album::where('id', $index)->update([
                'ordering' => $newPosition,
            ]);
        }

        flash()->addSuccess('Album ordering has been successfuly updated.');
    }

    public function deleteFoto($id)
    {
        $foto = Foto::find($id);
        $this->dispatchBrowserEvent('deleteFoto', [
            'title' => 'Are you sure?',
            'html' => 'You want to delete <b>' . $foto->title . '</b> foto',
            'id' => $id,
        ]);
    }

    public function deleteFotoAction($id)
    {
        $foto = Foto::find($id);
        $path = 'back/images/album/foto/';
        $path1 = 'back/images/album/foto/thumbnails/thumb_';
        $path2 = 'back/images/album/foto/thumbnails/thumb_75_';
        $path3 = 'back/images/album/foto/thumbnails/thumb_271_';
        $featured_image = $foto->img;
        if ($featured_image != null && Storage::disk('public')->exists($path . $featured_image)) {
            // delete post fetaured image
            Storage::disk('public')->delete($path . $featured_image);
        }
        if ($featured_image != null && Storage::disk('public')->exists($path1 . $featured_image)) {
            // delete post fetaured image
            Storage::disk('public')->delete($path1 . $featured_image);
        }
        if ($featured_image != null && Storage::disk('public')->exists($path2 . $featured_image)) {
            // delete post fetaured image
            Storage::disk('public')->delete($path2 . $featured_image);
        }
        if ($featured_image != null && Storage::disk('public')->exists($path3 . $featured_image)) {
            // delete post fetaured image
            Storage::disk('public')->delete($path3 . $featured_image);
        }

        $delete_foto = $foto->delete();
        if ($delete_foto) {
            flash()->addSuccess('Foto has been successfuly deleted!');
            activity()
                ->causedBy(auth()->user())
                ->log('Deleted foto ' . $foto->title);
        } else {
            flash()->addError('Something went wrong!');
        }
    }

    public function deleteSelectedFotos($album = null)
    {
        if ($album) {
            $fotos = Foto::whereIn('id', $this->selectedFotos)->where('album_id', $album)->get();
        } else {
            $fotos = Foto::whereIn('id', $this->selectedFotos)->get();
        }


        foreach ($fotos as $foto) {
            $path = 'back/images/album/foto/';
            $path1 = 'back/images/album/foto/thumbnails/thumb_';
            $path2 = 'back/images/album/foto/thumbnails/thumb_75_';
            $path3 = 'back/images/album/foto/thumbnails/thumb_271_';
            $featured_image = $foto->img;
            if ($featured_image != null && Storage::disk('public')->exists($path . $featured_image)) {
                Storage::disk('public')->delete($path . $featured_image);
            }
            if ($featured_image != null && Storage::disk('public')->exists($path1 . $featured_image)) {
                Storage::disk('public')->delete($path1 . $featured_image);
            }
            if ($featured_image != null && Storage::disk('public')->exists($path2 . $featured_image)) {
                Storage::disk('public')->delete($path2 . $featured_image);
            }
            if ($featured_image != null && Storage::disk('public')->exists($path3 . $featured_image)) {
                Storage::disk('public')->delete($path3 . $featured_image);
            }
            $foto->delete();
        }
        $this->selectedFotos = [];
        flash()->addSuccess('Selected fotos have been successfully deleted!');
        activity()
            ->causedBy(auth()->user())
            ->log('Deleted selected fotos');
    }

    public function selectAllFotos()
    {
        if ($this->album) {
            $this->selectedFotos = Foto::where('album_id', $this->album)->pluck('id')->toArray();
        } else {
            $this->selectedFotos = Foto::pluck('id')->toArray();
        }
    }
    // Method untuk video
    private function resetVideoInputs()
    {
        $this->video_name = '';
        $this->video_url = '';
        $this->selected_video_id = null;
        $this->updateVideoMode = false;
    }

    public function addVideo()
    {
        $this->validate([
            'video_name' => 'required',
            'video_url' => 'required'
        ]);

        Video::create([
            'video_name' => $this->video_name,
            'video_url' => $this->video_url
        ]);

        $this->resetVideoInputs();
        $this->dispatchBrowserEvent('hideVideoModal');
        flash()->addSuccess('Video added successfully');
        activity()
            ->causedBy(auth()->user())
            ->log('Created video ' . $this->video_name);
    }

    public function editVideo($id)
    {
        $video = Video::findOrFail($id);
        $this->selected_video_id = $video->id;
        $this->video_name = $video->video_name;
        $this->video_url = $video->video_url;
        $this->updateVideoMode = true;
        $this->resetErrorBag();
        $this->dispatchBrowserEvent('showVideoModal');
    }
    public function updateVideo()
    {
        $this->validate([
            'video_name' => 'required',
            'video_url' => 'required|url'
        ]);

        $video = Video::find($this->selected_video_id);
        $video->update([
            'video_name' => $this->video_name,
            'video_url' => $this->video_url
        ]);

        $this->resetVideoInputs();
        $this->dispatchBrowserEvent('hideVideoModal');
        flash()->addSuccess('Video updated successfully');
        activity()
            ->causedBy(auth()->user())
            ->log('Updated video ' . $this->video_name);
    }

    public function deleteVideo($id)
    {
        try {
            $video = Video::findOrFail($id);
            $this->dispatchBrowserEvent('confirmDelete', [
                'id' => $id,
                'name' => $video->video_name
            ]);
        } catch (\Exception $e) {
            flash()->addError('Error: ' . $e->getMessage());
        }
    }

    public function deleteVideoAction($id)
    {
        try {
            $video = Video::findOrFail($id);
            $deleted = $video->delete();

            if ($deleted) {
                flash()->addSuccess('Video deleted successfully');
                activity()
                    ->causedBy(auth()->user())
                    ->log('Deleted video ' . $video->video_name);
            } else {
                flash()->addError('Failed to delete video');
            }
        } catch (\Exception $e) {
            flash()->addError('Error: ' . $e->getMessage());
        }
    }
    public function render()
    {
        $Albums = Album::when($this->searchAlbum, function ($query) {
            return $query->where('album_name', 'like', '%' . $this->searchAlbum . '%');
        })->paginate(10);

        $videos = Video::when($this->searchVideo, function ($query) {
            return $query->where('video_name', 'like', '%' . $this->searchVideo . '%')
                ->orWhere('video_url', 'like', '%' . $this->searchVideo . '%');
        })->paginate(10);

        $fotos = Foto::when($this->album, function ($query) {
            $query->where('album_id', $this->album);
        })
            ->orderBy('created_at', 'desc')->paginate($this->perPage);

        $AlbumList = Album::whereHas('foto')->get();

        // Modify this line to use pagination
        $albums = Album::orderBy('ordering', 'asc')->paginate($this->perPageAlbum);

        return view('livewire.back.documentation.album-foto', [
            'Albums' => $Albums,
            'videos' => $videos,
            'fotos' => $fotos,
            'Albumss' => Album::all(),
            'AlbumList' => $AlbumList,
        ]);
    }
}
