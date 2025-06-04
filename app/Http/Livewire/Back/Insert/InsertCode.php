<?php

namespace App\Http\Livewire\Back\Insert;

use App\Models\InsertCodeSeo;
use Livewire\Component;
use Illuminate\Support\Facades\File;

class InsertCode extends Component
{
    public $gtag_analytics_id;
    public $gtag_analytics;
    public $gtag_header;
    public $gtag_body;
    public $bing;
    public $duckduckgo;
    public $yandex;
    public $baidu;
    public $pinterest;
    public $gsc;

    public function mount()
    {
        $konfigurasi = InsertCodeSeo::find(1);
        $this->gtag_analytics_id = optional($konfigurasi)->gtag_analytics_id;
        $this->gtag_analytics = optional($konfigurasi)->gtag_analytics;
        $this->gtag_header = optional($konfigurasi)->gtag_header;
        $this->gtag_body = optional($konfigurasi)->gtag_body;
        $this->bing = optional($konfigurasi)->bing;
        $this->duckduckgo = optional($konfigurasi)->duckduckgo;
        $this->yandex = optional($konfigurasi)->yandex;
        $this->baidu = optional($konfigurasi)->baidu;
        $this->pinterest = optional($konfigurasi)->pinterest;
        $this->gsc = optional($konfigurasi)->gsc;
    }

    public function storeCode()
    {
        // Update database values
        InsertCodeSeo::updateOrCreate(
            ['id' => 1],
            [
                'gtag_analytics_id' => $this->gtag_analytics_id,
                'gtag_analytics' => $this->gtag_analytics,
                'gtag_header' => $this->gtag_header,
                'gtag_body' => $this->gtag_body,
                'bing' => $this->bing,
                'yandex' => $this->yandex,
                'pinterest' => $this->pinterest,
                'gsc' => $this->gsc,
            ]
        );

        // Update .env file with the new google_analytics value as ANALYTICS_PROPERTY_ID
        $this->updateEnvFile('ANALYTICS_PROPERTY_ID', $this->gtag_analytics_id);

        // Log and flash success message
        activity()->causedBy(auth()->user())->log('Updated insert code seo');
        flash()->addSuccess('Kode seo berhasil disimpan.');
    }

    /**
     * Function to update the .env file with new value
     */
    public function updateEnvFile($key, $value)
    {
        $path = base_path('.env');
        $env = File::get($path);

        // Check if the key already exists in .env and update its value
        if (strpos($env, "{$key}=") !== false) {
            $env = preg_replace("/^{$key}=(.*)$/m", "{$key}={$value}", $env);
        } else {
            // If the key doesn't exist, append it at the end
            $env .= "\n{$key}={$value}";
        }

        // Save the updated .env file
        File::put($path, $env);

        // Clear the config cache to apply changes immediately
        \Artisan::call('config:clear');
    }

    public function render()
    {
        return view('livewire.back.insert.insert-code');
    }
}
