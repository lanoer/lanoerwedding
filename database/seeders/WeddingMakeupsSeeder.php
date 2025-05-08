<?php

namespace Database\Seeders;

use App\Models\WeddingMakeups;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class WeddingMakeupsSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $weddingMakeups = [
            [
                'name' => 'Wedding Makeup',
                'image' => 'wedding_makeup.jpg',
                'description' => 'Wedding Makeup',
            ],
        ];
        foreach ($weddingMakeups as $weddingMakeup) {
            WeddingMakeups::create($weddingMakeup);
        }
    }
}
