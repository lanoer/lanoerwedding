<?php

namespace App\Http\Livewire\Back\Setting;

use App\Models\Social;
use Livewire\Component;

class SocialMedia extends Component
{
    public $social_media;

    public $facebook;

    public $instagram;

    public $youtube;

    public $web;

    public $twitter;

    public function mount()
    {
        $this->social_media = Social::find(1);
        $this->facebook = optional($this->social_media)->facebook;
        $this->instagram = optional($this->social_media)->instagram;
        $this->youtube = optional($this->social_media)->youtube;
        $this->twitter = optional($this->social_media)->twitter;
        $this->web = optional($this->social_media)->web;
    }

    public function UpdateBlogSocialMedia()
    {
        $data = [
            'facebook' => $this->facebook,
            'instagram' => $this->instagram,
            'youtube' => $this->youtube,
            'twitter' => $this->twitter,
            'web' => $this->web,
        ];

        $this->social_media = Social::updateOrCreate(['id' => 1], $data);

        if ($this->social_media->wasRecentlyCreated) {
            flash()->addSuccess('Social media has been successfully created.');
            activity()
                ->causedBy(auth()->user())
                ->log('Created social media');
        } else {
            flash()->addSuccess('Social media has been successfully updated.');
            activity()
                ->causedBy(auth()->user())
                ->log('Updated social media');
        }
    }

    public function render()
    {
        return view('livewire.back.setting.social-media');
    }
}
