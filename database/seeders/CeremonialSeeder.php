<?php

namespace Database\Seeders;

use App\Models\Ceremonial;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class CeremonialSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $ceremonials = [
            [
                'name' => 'Ceremonial',
                'image' => 'ceremonial.jpg',
                'description' => 'Ceremonial',
            ],
        ];
        foreach ($ceremonials as $ceremonial) {
            Ceremonial::create($ceremonial);
        }
    }
}
