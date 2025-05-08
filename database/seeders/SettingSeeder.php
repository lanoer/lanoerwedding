<?php

namespace Database\Seeders;

use App\Models\Setting;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class SettingSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        Setting::create([
            'web_name' => 'Lanoer Wedding',
            'web_tagline' => 'Lanoer Wedding',
            'web_email' => 'cs@lanoerwedding.com',
            'web_email_noreply' => 'noreply@lanoerwedding.com',
            'web_telp' => '085725071996',
            'web_maps' => 'https://maps.app.goo.gl/SnXsikK7A8VCGxHU6',
            'web_desc' => 'Lanoer Wedding Event Organizer',
            'web_alamat' => 'Jl. Raya Kedungjaya No.1, Kedungjaya, Kec. Kedungjaya, Kabupaten Kedungjaya, Jawa Tengah 56511',
            'web_working_hours' => 'Senin - Sabtu 08:00 - 17:00',
        ]);
    }
}
