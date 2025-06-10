<?php

namespace App\Http\Livewire\Back\About;

use Livewire\Component;
use Livewire\WithFileUploads;
use App\Models\About;
use Illuminate\Support\Facades\Storage;
use Intervention\Image\ImageManagerStatic;
use Illuminate\Support\Str;

class AboutPage extends Component
{
    use WithFileUploads;

    public $title;
    public $description;
    public $meta_description;
    public $meta_keywords;
    public $meta_tags;
    public $image;

    public function mount()
    {
        $data = About::find(1);
        $this->title = optional($data)->title;
        $this->image = optional($data)->image;
        $this->description = optional($data)->description;
        $this->meta_description = optional($data)->meta_description;
        $this->meta_keywords = optional($data)->meta_keywords;
        $this->meta_tags = optional($data)->meta_tags;
    }

    public function saveAbout()
    {
        $rules = [
            'title' => 'required',
            'image' => 'required',
            'description' => 'required',
            'meta_description' => 'required',
            'meta_keywords' => 'required',
            'meta_tags' => 'required',
        ];

        // Tambahkan aturan validasi untuk gambar hanya jika gambar diunggah
        if ($this->image && ! is_string($this->image)) {
            $rules['image'] = 'sometimes|image|mimes:jpeg,png,jpg,gif,svg|max:2048';
        }

        $messages = [
            'title.required' => 'Title wajib diisi',
            'description.required' => 'Deskripsi singkat wajib diisi',
            'meta_description.required' => 'Meta Deskripsi lengkap wajib diisi',
            'meta_keywords.required' => 'Meta Keywords wajib diisi',
            'meta_tags.required' => 'Meta Tags wajib diisi',
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
        $about->description = $this->description;
        $about->meta_description = $this->meta_description;
        $about->meta_keywords = $this->meta_keywords;
        $about->meta_tags = $this->meta_tags;

        $path = 'back/images/about/';

        if ($this->image && !is_string($this->image)) {
            if ($about->image && Storage::disk('public')->exists($path . $about->image)) {
                Storage::disk('public')->delete($path . $about->image);
            }

            $file = $this->image;

            $extension = $file->getClientOriginalExtension();

            $new_filename = str::slug($about->title) . '.' . $extension;

            $img = ImageManagerStatic::make($file)->encode('jpg');

            Storage::disk('public')->put($path . $new_filename, $img);

            $about->image = $new_filename;
            $about->image_alt_text = $new_filename;
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
