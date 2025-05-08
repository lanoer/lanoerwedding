<?php

namespace Database\Seeders;

use App\Models\LiveMusic;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class LiveMusicSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $liveMusics = [
            [
                'lives_id' => 1,
                'name' => 'Live Music',
                'image' => 'live_music.jpg',
                'description' => 'Live Music',
            ],
            [
                'lives_id' => 2,
                'name' => 'Live Music 2',
                'image' => 'live_music.jpg',
                'description' => 'Live Music 2',
            ],
            [
                'lives_id' => 3,
                'name' => 'Live Music 3',
                'image' => 'live_music.jpg',
                'description' => 'Live Music 3',
            ],

        ];
        foreach ($liveMusics as $liveMusic) {
            LiveMusic::create($liveMusic);
        }
    }
}
