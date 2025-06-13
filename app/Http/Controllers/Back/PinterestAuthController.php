<?php

namespace App\Http\Controllers\Back;

use App\Http\Controllers\Controller;
use App\Models\SocialToken;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Log;

class PinterestAuthController extends Controller
{
    public function redirect()
    {
        $query = http_build_query([
            'response_type' => 'code',
            'client_id' => config('services.pinterest.client_id'),
            'redirect_uri' => config('services.pinterest.redirect_uri'),
            'scope' => 'boards:read pins:write',
        ]);

        return redirect('https://www.pinterest.com/oauth/?' . $query);
    }

    public function callback(Request $request)
    {
        $code = $request->query('code');

        if (!$code) {
            return redirect('/home')->with('error', 'Pinterest tidak mengirimkan kode.');
        }
        dd([
            'code' => $code,
            'redirect_uri' => config('services.pinterest.redirect_uri'),
            'client_id' => config('services.pinterest.client_id'),
            'client_secret' => config('services.pinterest.client_secret'),
        ]);
        // Debugging
        Log::info('Pinterest code received', ['code' => $code]);

        $response = Http::asForm()->withHeaders([
            'Content-Type' => 'application/x-www-form-urlencoded'
        ])->post('https://api.pinterest.com/v5/oauth/token', [
            'grant_type' => 'authorization_code',
            'code' => $code,
            'redirect_uri' => config('services.pinterest.redirect_uri'),
            'client_id' => config('services.pinterest.client_id'),
            'client_secret' => config('services.pinterest.client_secret'),
        ]);

        // Debug result
        Log::info('Pinterest token response', [
            'status' => $response->status(),
            'body' => $response->body()
        ]);

        if ($response->successful()) {
            $data = $response->json();

            SocialToken::updateOrCreate(
                ['provider' => 'pinterest'],
                [
                    'access_token' => $data['access_token'],
                    'expires_at' => now()->addSeconds($data['expires_in'] ?? 3600),
                ]
            );

            return redirect('/home')->with('success', 'Pinterest token berhasil disimpan.');
        }

        return redirect('/home')->with('error', 'Pinterest Token Error: ' . $response->body());
    }
}
