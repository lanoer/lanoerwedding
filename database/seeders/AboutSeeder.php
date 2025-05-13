<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\About;

class AboutSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        About::create([
            'title' => 'Lanoer Wedding & Event Organizer',
            'desc_singkat' => 'We would love to meet up and chat about how we can make your dream wedding happen!',
            'desc_lengkap' => 'Our team is made up of a group of creative and passionate people who are dedicated to making your wedding dreams come true. We are here to help you plan your dream wedding with ease and confidence.',
            'image' => 'About',
            'ourmission' => 'Our mission is to provide the best possible service to our clients. We are dedicated to making your wedding dreams come true with ease and confidence.',
            'ourvision' => 'To be the leading provider of wedding solutions that are innovative and reliable in Indonesia, with a focus on the latest technology and premium service to create a safe, comfortable, and efficient environment for all of our clients.',
            'ourcommitment' => 'We believe that security is a basic need that every individual and business should have. Therefore, we are committed to providing reliable security solutions that are easily accessible to all of our clients. Thank you for trusting us as your security and automation provider. We are ready to help you create a safer and more comfortable environment.',
            'complete_project' => '1',
            'client_review' => '1',
        ]);
    }
}
