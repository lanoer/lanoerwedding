<?php

namespace App\Services;

use GuzzleHttp\Client;

class BingService
{
    protected $client;
    protected $apiKey;

    public function __construct()
    {
        $this->client = new Client();
        $this->apiKey = env('BING_API_KEY'); // Ambil API Key dari file .env
    }

    public function submitUrl($url)
    {
        $response = $this->client->post('https://ssl.bing.com/webmasters/api/properties/submitUrl', [
            'headers' => [
                'Authorization' => 'Bearer ' . $this->apiKey,
                'Content-Type' => 'application/json'
            ],
            'json' => [
                'url' => $url
            ]
        ]);

        return $response->getBody()->getContents();
    }
}
