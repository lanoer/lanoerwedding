<?php

namespace Database\Seeders;

use App\Models\MediumCatering;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class MediumCateringSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $MediumCatering = [
            [
                'name' => 'Medium Catering A',
                'catering_packages_id' => 1,
                'slug' => 'medium-catering-a',
                'description' => 'Medium Catering A description',
                'image' => 'Medium_catering_a.jpg',
                'meta_description' => 'Medium Catering A meta description',
                'meta_keywords' => 'Medium, catering, A',
                'meta_tags' => 'Medium, catering, A',
                'image_alt_text' => 'Medium_catering_a.jpg',
            ],

        ];
        foreach ($MediumCatering as $d) {
            MediumCatering::create($d);
        }
    }
}
