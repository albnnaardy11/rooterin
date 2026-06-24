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
            // Core Modular Seeders
            UserSeeder::class,
            SettingSeeder::class,
            PostSeeder::class,
            ServiceSeeder::class,
            ProjectSeeder::class,
            TestimonialSeeder::class,

            // Missing Seeders
            FaqSeeder::class,
            PartnerDiscoverySeeder::class,
            WikiBulkSeeder::class,
            WikiEntitySeeder::class,
            WikiPipaSeeder::class,
            TipsBulkSeeder::class,
        ]);
    }
}
