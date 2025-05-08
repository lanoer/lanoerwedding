<?php

namespace Database\Seeders;

use App\Models\CeremonialEvent;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class CeremonialEventSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $ceremonialEvents = [
            [
                'ceremonial_id' => 1,
                'name' => 'Ceremonial',
                'image' => 'ceremonial.jpg',
                'description' => 'Ceremonial',
            ],
            [
                'ceremonial_id' => 2,
                'name' => 'Ceremonial 2',
                'image' => 'ceremonial.jpg',
                'description' => 'Ceremonial 2',
            ],
            [
                'ceremonial_id' => 3,
                'name' => 'Ceremonial 3',
                'image' => 'ceremonial.jpg',
                'description' => 'Ceremonial 3',
            ],

        ];
        foreach ($ceremonialEvents as $ceremonialEvent) {
            CeremonialEvent::create($ceremonialEvent);
        }
    }
}
