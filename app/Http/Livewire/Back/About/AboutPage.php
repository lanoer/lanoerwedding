<?php

namespace App\Http\Livewire\Back\About;

use Livewire\Component;
use Livewire\WithFileUploads;
use App\Models\About;
use Illuminate\Support\Facades\Storage;
use Intervention\Image\ImageManagerStatic;

class AboutPage extends Component
{
    use WithFileUploads;

    public $title;

    public $desc_singkat;

    public $desc_lengkap;

    public $ourmission;

    public $ourvision;

    public $ourcommitment;

    public $image;

    public $complete_project;

    public $client_review;

    public function mount()
    {
        $data = About::find(1);
        $this->title = optional($data)->title;
        $this->desc_singkat = optional($data)->desc_singkat;
        $this->desc_lengkap = optional($data)->desc_lengkap;
        $this->ourmission = optional($data)->ourmission;
        $this->ourvision = optional($data)->ourvision;
        $this->ourcommitment = optional($data)->ourcommitment;
        $this->image = optional($data)->image;
        $this->complete_project = optional($data)->complete_project;
        $this->client_review = optional($data)->client_review;
    }

    public function saveAbout()
    {
        $rules = [
            'title' => 'required',
            'desc_singkat' => 'required',
            'desc_lengkap' => 'required',
            'ourmission' => 'required',
            'ourvision' => 'required',
            'ourcommitment' => 'required',
            'complete_project' => 'required',
            'client_review' => 'required',
        ];

        // Tambahkan aturan validasi untuk gambar hanya jika gambar diunggah
        if ($this->image && ! is_string($this->image)) {
            $rules['image'] = 'sometimes|image|mimes:jpeg,png,jpg,gif,svg|max:2048';
        }

        $messages = [
            'title.required' => 'Title wajib diisi',
            'desc_singkat.required' => 'Deskripsi singkat wajib diisi',
            'desc_lengkap.required' => 'Deskripsi lengkap wajib diisi',
            'ourmission.required' => 'Misi wajib diisi',
            'ourvision.required' => 'Visi wajib diisi',
            'ourcommitment.required' => 'Komitmen wajib diisi',
            'complete_project.required' => 'Complete Project wajib diisi',
            'client_review.required' => 'Client Review wajib diisi',
            'image.image' => 'Image header harus berupa gambar.',
            'image.mimes' => 'Image header harus berupa extension JPG, JPEG, PNG, dan SVG.',
            'image.max' => 'Ukuran image header tidak boleh lebih dari 2 MB.',
        ];

        $this->validate($rules, $messages);

        $about = About::find(1);
        if (! $about) {
            $about = new About();
        }

        $about->title = $this->title;
        $about->desc_singkat = $this->desc_singkat;
        $about->desc_lengkap = $this->desc_lengkap;
        $about->ourmission = $this->ourmission;
        $about->ourvision = $this->ourvision;
        $about->ourcommitment = $this->ourcommitment;
        $about->complete_project = $this->complete_project;
        $about->client_review = $this->client_review;

        $path = 'back/images/about/';

        if ($this->image && ! is_string($this->image)) {
            if ($about->image && Storage::disk('public')->exists($path . $about->image)) {
                Storage::disk('public')->delete($path . $about->image);
            }
            $file = $this->image;
            $filename = $file->getClientOriginalName();
            $new_filename = date('YmdHis') . '' . $filename;
            $img = ImageManagerStatic::make($file)->encode('jpg');
            Storage::disk('public')->put($path . $new_filename, $img);
            $about->image = $new_filename;
        }

        $saved = $about->save();
        if ($saved) {
            activity()
                ->causedBy(auth()->user())
                ->log('Updated about');

            flash()->addSuccess('About has been successfully updated.');
        } else {
            flash()->addError('Something went wrong!');
        }
    }

    public function render()
    {
        return view('livewire.back.about.about-page');
    }
}
