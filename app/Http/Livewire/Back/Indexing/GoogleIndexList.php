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

    protected $rules = [
        'urls' => 'required|string',
    ];

    protected $messages = [
        'urls.required' => 'The URLs field cannot be empty.',
        'urls.string' => 'The URLs field must be a valid string.',
    ];



    public function requestIndexing($type)
    {
        $this->validate();

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
        $client->setAuthConfig(storage_path('app/indexing/lanoer-wedding-1dbfa13833cc.json'));
        $client->addScope(Google_Service_Indexing::INDEXING);

        $service = new Google_Service_Indexing($client);

        foreach ($urls as $url) {
            $urlNotification = new Google_Service_Indexing_UrlNotification();
            $urlNotification->setType($type);
            $urlNotification->setUrl($url);

            try {
                $service->urlNotifications->publish($urlNotification);
                session()->flash('message', 'Indexing request sent successfully for URL: ' . $url);
            } catch (\Exception $e) {
                session()->flash('error', 'Failed to send indexing request for URL: ' . $url . '. Error: ' . $e->getMessage());
            }
        }
    }

    public function getStatus()
    {
        $this->validate();

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
        $client->setAuthConfig(storage_path('app/indexing/lanoer-wedding-1dbfa13833cc.json'));
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
    public function render()
    {
        return view('livewire.back.indexing.google-index-list');
    }
}
