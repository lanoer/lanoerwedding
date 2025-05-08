<?php

namespace Database\Seeders;

use App\Models\Decorations;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class DecorationSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $decorations = [
            [
                'name' => 'Dekoraso A',
                'description' => 'Dekorasi A description',
                'image' => 'dekorasi.jpg',
                'is_active' => true,
            ],
        ];
        foreach ($decorations as $d) {
            Decorations::create($d);
        }
    }
}
