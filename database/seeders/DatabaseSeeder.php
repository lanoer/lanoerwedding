<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;


class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        $this->call([
            UserRolePermissionSeeder::class,
            LogoSeeder::class,
            SettingSeeder::class,
            SocialMediaSeeder::class,
            EventMakeupsSeeder::class,
            EventSeeder::class,
            WeddingMakeupsSeeder::class,
            WeddingsSeeder::class,
            DecorationSeeder::class,
            SoundSytemSeeder::class,
            SoundSeeder::class,
            LiveSeeder::class,
            LiveMusicSeeder::class,
            CeremonialSeeder::class,
            CeremonialEventSeeder::class,
            AboutSeeder::class,
        ]);
    }
}
