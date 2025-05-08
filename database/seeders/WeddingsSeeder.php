<?php

namespace Database\Seeders;

use App\Models\Weddings;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class WeddingsSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $weddings = [
            [
                'wedding_makeups_id' => 1,
                'name' => 'Wedding 1',
                'description' => 'Wedding 1 description',
                'image' => 'wedding_1.jpg',
                'is_active' => true,
            ],
        ];
        foreach ($weddings as $wedding) {
            Weddings::create($wedding);
        }
    }
}
