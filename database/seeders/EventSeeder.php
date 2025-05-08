<?php

namespace Database\Seeders;

use App\Models\Event;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class EventSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $events = [
            [
                'event_makeups_id' => 1,
                'name' => 'Event 1',
                'description' => 'Event 1 description',
                'image' => 'event_1.jpg',
                'is_active' => true,
            ],
            [
                'event_makeups_id' => 1,
                'name' => 'Event 2',
                'description' => 'Event 2 description',
                'image' => 'event_2.jpg',
                'is_active' => true,
            ],
        ];
        foreach ($events as $event) {
            Event::create($event);
        }
    }
}
