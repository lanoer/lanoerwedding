<?php

namespace Database\Seeders;

use App\Models\SoundSystem;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class SoundSytemSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $sounds = [
            [
                'sounds_id' => 1,
                'name' => 'Sound 1',
                'description' => 'Sound 1 description',
                'image' => 'sound_1.jpg',
                'is_active' => true,
            ],
            [
                'sounds_id' => 1,
                'name' => 'Sound 2',
                'description' => 'Sound 2 description',
                'image' => 'sound_2.jpg',
                'is_active' => true,
            ],
        ];
        foreach ($sounds as $sound) {
            SoundSystem::create($sound);
        }
    }
}
