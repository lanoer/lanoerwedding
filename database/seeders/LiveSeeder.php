<?php

namespace Database\Seeders;

use App\Models\Live;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class LiveSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $lives = [
            [
                'name' => 'Live Music',
                'image' => 'live_music.jpg',
                'description' => 'Live Music',
            ],
        ];
        foreach ($lives as $live) {
            Live::create($live);
        }
    }
}
