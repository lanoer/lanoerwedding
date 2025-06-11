<?php

namespace Database\Seeders;

use App\Models\PremiumCatering;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class PremiumCateringSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $PremiumCatering = [
            [
                'name' => 'Premium Catering A',
                'catering_packages_id' => 1,
                'slug' => 'premium-catering-a',
                'description' => 'Premium Catering A description',
                'image' => 'Premium_catering_a.jpg',
                'meta_description' => 'Premium Catering A meta description',
                'meta_keywords' => 'Premium, catering, A',
                'meta_tags' => 'Premium, catering, A',
                'image_alt_text' => 'Premium_catering_a.jpg',
            ],

        ];
        foreach ($PremiumCatering as $d) {
            PremiumCatering::create($d);
        }
    }
}
