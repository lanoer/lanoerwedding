<?php

namespace Database\Seeders;

use App\Models\Logo;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class LogoSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        Logo::create([
            'logo_utama' => null,
            'logo_email' => null,
            'logo_favicon' => null,
            'logo_front' => null,
            'logo_front2' => null,
        ]);
    }
}
