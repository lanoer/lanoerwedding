<?php

namespace Database\Seeders;

use App\Models\EventMakeups;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class EventMakeupsSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $eventMakeups = [
            [
                'name' => 'Event Makeup',
                'image' => 'event_makeup.jpg',
                'description' => 'Event Makeup',
            ],
        ];
        foreach ($eventMakeups as $eventMakeup) {
            EventMakeups::create($eventMakeup);
        }
    }
}
