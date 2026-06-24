<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Setting;

class SettingSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $settings = [
            ['key' => 'site_name', 'value' => 'RooterIn', 'group' => 'general'],
            ['key' => 'whatsapp_number', 'value' => '6281292059125', 'group' => 'contact'],
            ['key' => 'email', 'value' => 'hello@rooterin.com', 'group' => 'contact'],
            ['key' => 'address', 'value' => 'Pulau Jawa & Sekitarnya', 'group' => 'contact'],
            ['key' => 'instagram', 'value' => 'https://instagram.com/rooterin', 'group' => 'social'],
            ['key' => 'facebook', 'value' => 'https://facebook.com/rooterin', 'group' => 'social'],
            ['key' => 'tiktok', 'value' => 'https://tiktok.com/@rooterin', 'group' => 'social'],
        ];

        foreach ($settings as $setting) {
            Setting::create($setting);
        }
    }
}
