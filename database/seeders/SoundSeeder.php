<?php

namespace Database\Seeders;

use App\Models\Sound;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class SoundSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $soundSystems = [
            [
                'name' => 'Sound System',
                'image' => 'sound_system.jpg',
                'description' => 'Sound System',
            ],
        ];
        foreach ($soundSystems as $soundSystem) {
            Sound::create($soundSystem);
        }
    }
}
