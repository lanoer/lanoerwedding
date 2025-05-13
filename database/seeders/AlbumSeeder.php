<?php

namespace Database\Seeders;

use App\Models\Album;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class AlbumSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        Album::create([
            'album_name' => 'Album 1',
        ]);
        Album::create([
            'album_name' => 'Album 2',
        ]);
    }
}
