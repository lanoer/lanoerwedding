<?php

namespace Database\Seeders;

use App\Models\Social;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class SocialMediaSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        Social::create([
            'facebook' => 'https://www.facebook.com/lanoerwedding',
            'instagram' => 'https://www.instagram.com/lanoerwedding/',
            'youtube' => 'https://www.youtube.com/@lanoerwedding',
            'twitter' => 'https://twitter.com/lanoerwedding',
            'tiktok' => 'https://www.tiktok.com/@lanoerwedding',
            'web' => 'https://www.lanoerwedding.com',
        ]);
    }
}
