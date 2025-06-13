<?php

namespace App\Http\Controllers\Back;

use App\Http\Controllers\Controller;
use App\Models\Decorations;
use App\Models\Post;
use App\Models\SocialToken;
use GuzzleHttp\Client;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Log;

class PinterestController extends Controller
{


    public function postToPinterest($type, $id)
    {
        $token = SocialToken::where('provider', 'pinterest')->first();

        if (!$token) {
            return back()->with('error', 'Pinterest token tidak tersedia.');
        }

        // Ambil konten berdasarkan tipe
        switch ($type) {
            case 'post':
                $content = Post::findOrFail($id);
                break;

            default:
                abort(404);
        }

        $image = $content->featured_image_url ?? null; // pastikan ada field ini
        $title = $content->title ?? 'No title';
        $url = url("/$type/{$content->slug}");

        // Ambil board ID (bisa disimpan default di config atau db)
        $boardId = config('services.pinterest.board_id');

        $response = Http::withToken($token->access_token)->post("https://api.pinterest.com/v5/pins", [
            'board_id' => $boardId,
            'title' => $title,
            'alt_text' => $title,
            'link' => $url,
            'media_source' => [
                'source_type' => 'image_url',
                'url' => $image
            ]
        ]);

        if ($response->successful()) {
            return back()->with('success', 'Berhasil dikirim ke Pinterest!');
        }
        Log::error('Pinterest Post Error', [
            'status' => $response->status(),
            'body' => $response->body(),
            'json' => $response->json(),
        ]);
        return back()->with('error', 'Gagal mengirim ke Pinterest.');
    }

    public function listBoards()
    {
        $response = Http::withToken(env('PINTEREST_ACCESS_TOKEN'))
            ->get('https://api.pinterest.com/v5/boards');
        // dd($response->status(), $response->json());
        if (!$response->successful()) {
            return back()->with('error', 'Gagal mengambil board: ' . $response->body());
        }

        $boards = $response->json('items');

        return view('back.pages.pinterest.boards', compact('boards'));
    }
}
