<?php

namespace App\Http\Livewire\Back\Gallery;

use App\Models\FotoGallery;
use App\Models\GalleryFoto as ModelsGalleryFoto;
use App\Models\VideoGallery;
use Google\Service\Bigquery\Model;
use Illuminate\Support\Facades\Storage;
use Livewire\Component;
use Livewire\WithFileUploads;
use Livewire\WithPagination;

class GalleryFoto extends Component
{
    use WithFileUploads;
    use WithPagination;

    protected $paginationTheme = 'bootstrap';

    public $gallery_name;

    public $selected_gallery_id;

    public $updateGalleryMode = false;

    public $perPage = 6;

    public $title;

    public $img;

    public $image;

    public $gallery_id;

    public $oldImg;

    public $selected_foto_gallery_id;

    public $updateFotoGalleryMode = false;

    public $gallery = null;

    public $selectedFotoGallerys = [];
    public $Videos = [];
    public $video_name;
    public $video_url;
    public $selected_video_id;
    public $updateVideoGalleryMode = false;
    public $perPageVideo = 5;
    public $perPageAlbum = 5;
    public $activeTab = 'gallerys';

    public $searchGallery = '';
    public $searchVideo = '';

    public $listeners = [
        'resetModalForm',
        'deleteGalleryAction',
        'updateGalleryOrdering',
        'deleteFotoGalleryAction',
        'deleteSelectedFotoGallerys',
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
        $this->gallery_name = null;
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

    public function editGallery($id)
    {
        $gallery = ModelsGalleryFoto::findOrFail($id);
        $this->selected_gallery_id = $gallery->id;
        $this->gallery_name = $gallery->gallery_name;
        $this->updateGalleryMode = true;
        $this->resetErrorBag();
        $this->dispatchBrowserEvent('showgalleryModal');
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
        $gallery = ModelsGalleryFoto::find($id);
        $this->dispatchBrowserEvent('deleteGallery', [
            'title' => 'Are you sure?',
            'html' => 'You want to delete <b>' . $gallery->gallery_name . '</b> gallery',
            'id' => $id,
        ]);
    }

    public function deleteGalleryAction($id)
    {
        $gallery = ModelsGalleryFoto::where('id', $id)->first();
        $foto = FotoGallery::where('gallery_id', $gallery->id)->get()->toArray();
        if (!empty($foto) && count($foto) > 0) {
            flash()->addError('This Gallery has (' . count($foto) . ') foto related it, cannot be deleted.');
        } else {
            $gallery->delete();
            flash()->addSuccess('Gallery has been successfuly deleted.');
            activity()
                ->causedBy(auth()->user())
                ->log('Deleted Gallery ' . $gallery->gallery_name);
        }
    }

    public function updateGalleryOrdering($positions)
    {
        foreach ($positions as $p) {
            $index = $p[0];
            $newPosition = $p[1];
            ModelsGalleryFoto::where('id', $index)->update([
                'ordering' => $newPosition,
            ]);
        }

        flash()->addSuccess('Gallery ordering has been successfuly updated.');
    }

    public function deleteFotoGallery($id)
    {
        $foto = FotoGallery::find($id);
        $this->dispatchBrowserEvent('deleteFotoGallery', [
            'title' => 'Are you sure?',
            'html' => 'You want to delete <b>' . $foto->title . '</b> foto',
            'id' => $id,
        ]);
    }

    public function deleteFotoGalleryAction($id)
    {
        $foto = FotoGallery::find($id);
        $path = 'back/images/gallery/foto/';
        $path1 = 'back/images/gallery/foto/thumbnails/thumb_';
        $path2 = 'back/images/gallery/foto/thumbnails/thumb_75_';
        $path3 = 'back/images/gallery/foto/thumbnails/thumb_271_';
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
            flash()->addSuccess('Foto Gallery has been successfuly deleted!');
            activity()
                ->causedBy(auth()->user())
                ->log('Deleted Foto Gallery ' . $foto->title);
        } else {
            flash()->addError('Something went wrong!');
        }
    }

    public function deleteSelectedFotosGallery($gallery = null)
    {
        if ($gallery) {
            $fotosGallery = FotoGallery::whereIn('id', $this->selectedFotosGallery)->where('gallery_fotos_id', $gallery)->get();
        } else {
            $fotosGallery = FotoGallery::whereIn('id', $this->selectedFotosGallery)->get();
        }


        foreach ($fotosGallery as $foto) {
            $path = 'back/images/gallery/foto/';
            $path1 = 'back/images/gallery/foto/thumbnails/thumb_';
            $path2 = 'back/images/gallery/foto/thumbnails/thumb_75_';
            $path3 = 'back/images/gallery/foto/thumbnails/thumb_271_';
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
        $this->selectedFotoGallerys = [];
        flash()->addSuccess('Selected foto Gallery have been successfully deleted!');
        activity()
            ->causedBy(auth()->user())
            ->log('Deleted selected foto gallery');
    }

    public function selectAllFotoGallerys()
    {
        if ($this->galery) {
            $this->selectedFotoGallerys = FotoGallery::where('gallery_fotos_id', $this->gallery)->pluck('id')->toArray();
        } else {
            $this->selectedFotoGallerys = FotoGallery::pluck('id')->toArray();
        }
    }
    // Method untuk video
    private function resetVideoInputs()
    {
        $this->video_name = '';
        $this->video_url = '';
        $this->selected_video_id = null;
        $this->updateVideoGalleryMode = false;
    }

    public function addVideo()
    {
        $this->validate([
            'video_name' => 'required',
            'video_url' => 'required'
        ]);

        VideoGallery::create([
            'video_name' => $this->video_name,
            'video_url' => $this->video_url
        ]);

        $this->resetVideoInputs();
        $this->dispatchBrowserEvent('hideVideoGalleryModal');
        flash()->addSuccess('Video Gallery added successfully');
        activity()
            ->causedBy(auth()->user())
            ->log('Created video Gallery' . $this->video_name);
    }

    public function editVideo($id)
    {
        $video = VideoGallery::findOrFail($id);
        $this->selected_video_id = $video->id;
        $this->video_name = $video->video_name;
        $this->video_url = $video->video_url;
        $this->updateVideoGalleryMode = true;
        $this->resetErrorBag();
        $this->dispatchBrowserEvent('showVideoGalleryModal');
    }
    public function updateVideo()
    {
        $this->validate([
            'video_name' => 'required',
            'video_url' => 'required|url'
        ]);

        $video = VideoGallery::find($this->selected_video_id);
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
            $video = VideoGallery::findOrFail($id);
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
            $video = VideoGallery::findOrFail($id);
            $deleted = $video->delete();

            if ($deleted) {
                flash()->addSuccess('Video Gallery deleted successfully');
                activity()
                    ->causedBy(auth()->user())
                    ->log('Deleted video Gallery ' . $video->video_name);
            } else {
                flash()->addError('Failed to delete video Gallery');
            }
        } catch (\Exception $e) {
            flash()->addError('Error: ' . $e->getMessage());
        }
    }
    public function render()
    {
        $Gallerys = ModelsGalleryFoto::when($this->searchGallery, function ($query) {
            return $query->where('gallery_name', 'like', '%' . $this->searchGallery . '%');
        })->paginate(10);

        $videos = VideoGallery::when($this->searchVideo, function ($query) {
            return $query->where('video_name', 'like', '%' . $this->searchVideo . '%')
                ->orWhere('video_url', 'like', '%' . $this->searchVideo . '%');
        })->paginate(10);

        $fotosGallery = FotoGallery::when($this->gallery, function ($query) {
            $query->where('gallery_fotos_id', $this->gallery);
        })
            ->orderBy('created_at', 'desc')->paginate($this->perPage);

        $GalleryList = ModelsGalleryFoto::whereHas('FotoGallery')->get();

        // Modify this line to use pagination
        // $albums = ModelsGalleryFoto::orderBy('ordering', 'asc')->paginate($this->perPageGallery);
        return view('livewire.back.gallery.gallery-foto', [
            'Gallerys' => $Gallerys,
            'videos' => $videos,
            'fotosGallery' => $fotosGallery,
            'Galleryss' => ModelsGalleryFoto::all(),
            'GalleryList' => $GalleryList,
        ]);
    }
}
