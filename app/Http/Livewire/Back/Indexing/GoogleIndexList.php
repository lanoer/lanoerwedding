<?php

namespace App\Http\Livewire\Back\Indexing;

use Livewire\Component;
use Google\Client as Google_Client;
use Illuminate\Support\Facades\Http;
use Google\Service\Indexing as Google_Service_Indexing;
use Google\Service\Indexing\UrlNotification as Google_Service_Indexing_UrlNotification;

class GoogleIndexList extends Component
{
    public $urls;
    public $bingUrls;
    public $googleMessage;
    public $googleError;
    public $bingMessage;
    public $bingError;
    protected $rules = [
        'urls' => 'string',
        'bingUrls' => 'string',
    ];

    protected $messages = [
        'urls.required' => 'The URLs field cannot be empty.',
        'urls.string' => 'The URLs field must be a valid string.',
        'bingUrls.required' => 'The Bing URLs field cannot be empty.',
        'bingUrls.string' => 'The Bing URLs field must be a valid string.',
    ];



    public function requestIndexing($type)
    {
        $this->reset(['googleMessage', 'googleError']);
        $this->validate([
            'urls' => 'required|string',
        ]);

        $urls = explode("\n", $this->urls);
        $urls = array_map('trim', $urls);
        $urls = array_filter($urls);

        foreach ($urls as $url) {
            if (!filter_var($url, FILTER_VALIDATE_URL)) {
                $this->googleError = 'Invalid URL: ' . $url;
                return;
            }
        }

        $client = new Google_Client();
        $client->setAuthConfig(storage_path('app/indexing/lanoer-wedding-fc018272308c.json'));
        $client->addScope(Google_Service_Indexing::INDEXING);

        $service = new Google_Service_Indexing($client);

        foreach ($urls as $url) {
            $urlNotification = new Google_Service_Indexing_UrlNotification();
            $urlNotification->setType($type);
            $urlNotification->setUrl($url);

            try {
                $service->urlNotifications->publish($urlNotification);
                $this->googleMessage = 'Indexing request sent successfully for URL: ' . $url;
            } catch (\Exception $e) {
                $this->googleError = 'Failed to send indexing request for URL: ' . $url . '. Error: ' . $e->getMessage();
            }
        }
    }

    public function getStatus()
    {
        $this->validate([
            'urls' => 'required|string',
        ]);

        $urls = explode("\n", $this->urls);
        $urls = array_map('trim', $urls);
        $urls = array_filter($urls);

        foreach ($urls as $url) {
            if (!filter_var($url, FILTER_VALIDATE_URL)) {
                session()->flash('error', 'Invalid URL: ' . $url);
                return;
            }
        }

        $client = new Google_Client();
        $client->setAuthConfig(storage_path('app/indexing/lanoer-wedding-fc018272308c.json'));
        $client->addScope(Google_Service_Indexing::INDEXING);

        $service = new Google_Service_Indexing($client);

        foreach ($urls as $url) {
            try {
                $response = $service->urlNotifications->getMetadata(['url' => $url]);
                session()->flash('message', 'Status for URL: ' . $url . ' - ' . json_encode($response));
            } catch (\Google_Service_Exception $e) {
                $error = json_decode($e->getMessage(), true);
                if (isset($error['error']['code']) && $error['error']['code'] == 404) {
                    session()->flash('error', 'URL not found in Google Index: ' . $url);
                } else {
                    session()->flash('error', 'Failed to get status for URL: ' . $url . '. Error: ' . $e->getMessage());
                }
            } catch (\Exception $e) {
                session()->flash('error', 'Failed to get status for URL: ' . $url . '. Error: ' . $e->getMessage());
            }
        }
    }

    public function requestGoogleIndexing($type)
    {
        $this->validate([
            'urls' => 'required|string',
        ]);


        $urls = explode("\n", $this->urls);
        $urls = array_map('trim', $urls);
        $urls = array_filter($urls);

        foreach ($urls as $url) {
            if (!filter_var($url, FILTER_VALIDATE_URL)) {
                session()->flash('error', 'Invalid URL: ' . $url);
                return;
            }
        }

        $client = new Google_Client();
        $client->setAuthConfig(storage_path('app/indexing/lanoer-wedding-fc018272308c.json'));
        $client->addScope(Google_Service_Indexing::INDEXING);

        $service = new Google_Service_Indexing($client);

        foreach ($urls as $url) {
            $urlNotification = new Google_Service_Indexing_UrlNotification();
            $urlNotification->setType($type);
            $urlNotification->setUrl($url);

            try {
                $service->urlNotifications->publish($urlNotification);
                session()->flash('message', 'Google Indexing request sent successfully for URL: ' . $url);
            } catch (\Exception $e) {
                session()->flash('error', 'Failed to send Google indexing request for URL: ' . $url . '. Error: ' . $e->getMessage());
            }
        }
    }

    public function sendGoogleIndexingRequest($urls, $type)
    {
        $client = new Google_Client();
        $client->setAuthConfig(storage_path('app/indexing/lanoer-wedding-fc018272308c.json'));
        $client->addScope(Google_Service_Indexing::INDEXING);

        $service = new Google_Service_Indexing($client);

        foreach ($urls as $url) {
            $urlNotification = new Google_Service_Indexing_UrlNotification();
            $urlNotification->setType($type);
            $urlNotification->setUrl($url);

            try {
                $service->urlNotifications->publish($urlNotification);
                session()->flash('message', 'Google Indexing request sent successfully for URL: ' . $url);
            } catch (\Exception $e) {
                session()->flash('error', 'Failed to send Google indexing request for URL: ' . $url . '. Error: ' . $e->getMessage());
            }
        }
    }

    // Fungsi untuk request indexing di Bing
    public function requestBingIndexing()
    {
        $this->reset(['bingMessage', 'bingError']);
        $this->validate([
            'bingUrls' => 'required|string',
        ]);

        $urls = explode("\n", $this->bingUrls);
        $urls = array_map('trim', $urls);
        $urls = array_filter($urls);

        foreach ($urls as $url) {
            if (!filter_var($url, FILTER_VALIDATE_URL)) {
                $this->bingError = 'Invalid URL: ' . $url;
                return;
            }
        }

        // Kirim permintaan indexing ke Bing
        $this->sendBingIndexingRequest($urls);
    }

    public function sendBingIndexingRequest($urls)
    {
        $apiKey = env('BING_API_KEY'); // Ambil API Key Bing dari file .env
        $bingUrl = 'https://ssl.bing.com/webmasters/api/properties/submitUrl';

        foreach ($urls as $url) {
            try {
                $response = Http::withHeaders([
                    'Authorization' => 'Bearer ' . $apiKey,
                    'Content-Type' => 'application/json',
                ])->post($bingUrl, [
                    'url' => $url,
                ]);

                if ($response->successful()) {
                    $this->bingMessage = 'Bing Indexing request sent successfully for URL: ' . $url;
                } else {
                    $this->bingError = 'Failed to send Bing indexing request for URL: ' . $url;
                }
            } catch (\Exception $e) {
                $this->bingError = 'Failed to send Bing indexing request for URL: ' . $url . '. Error: ' . $e->getMessage();
            }
        }
    }


public function requestBingDeletion()
{
    $this->reset(['bingMessage', 'bingError']);
    $this->validate([
        'bingUrls' => 'required|string',
    ]);

    $urls = explode("\n", $this->bingUrls);
    $urls = array_map('trim', $urls);
    $urls = array_filter($urls);

    foreach ($urls as $url) {
        if (!filter_var($url, FILTER_VALIDATE_URL)) {
            $this->bingError = 'Invalid URL: ' . $url;
            return;
        }
    }

    $apiKey = env('BING_API_KEY');
    $siteUrl = env('BING_SITE_URL');
    $bingUrl = "https://ssl.bing.com/webmasters/api/sites/{$siteUrl}/urlRemovals";

    foreach ($urls as $url) {
        try {
            $response = Http::withHeaders([
                'Api-Key' => $apiKey,
                'Content-Type' => 'application/json',
            ])->post($bingUrl, [
                'siteUrl' => $siteUrl,
                'urlList' => [$url],
            ]);

            if ($response->successful()) {
                $this->bingMessage = 'Bing Deletion request sent successfully for URL: ' . $url;
            } else {
                $this->bingError = 'Failed to send Bing deletion request for URL: ' . $url;
            }
        } catch (\Exception $e) {
            $this->bingError = 'Failed to send Bing deletion request for URL: ' . $url . '. Error: ' . $e->getMessage();
        }
    }
}
    public function render()
    {
        return view('livewire.back.indexing.google-index-list');
    }
}
