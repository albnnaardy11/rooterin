<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    use WithoutModelEvents;

    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        // Admin User
        User::factory()->create([
            'name' => 'Admin RooterIn',
            'email' => 'admin@rooterin.com',
            'password' => bcrypt('password'),
        ]);

        // --- Settings Seeder ---
        $settings = [
            ['key' => 'site_name', 'value' => 'RooterIn', 'group' => 'general'],
            ['key' => 'whatsapp_number', 'value' => '6281246668749', 'group' => 'contact'],
            ['key' => 'email', 'value' => 'hello@rooterin.com', 'group' => 'contact'],
            ['key' => 'address', 'value' => 'Denpasar, Bali', 'group' => 'contact'],
            ['key' => 'instagram', 'value' => 'https://instagram.com/rooterin', 'group' => 'social'],
            ['key' => 'facebook', 'value' => 'https://facebook.com/rooterin', 'group' => 'social'],
            ['key' => 'tiktok', 'value' => 'https://tiktok.com/@rooterin', 'group' => 'social'],
        ];
        foreach ($settings as $setting) {
            \App\Models\Setting::create($setting);
        }

        // --- Posts Seeder ---
        $posts = [
            [
                'title' => 'Cara Darurat Atasi Wastafel Mampet Tanpa Bongkar',
                'slug' => 'cara-darurat-atasi-wastafel-mampet-tanpa-bongkar',
                'category' => 'Dapur',
                'content' => 'Wastafel mampet di tengah malam? Jangan panik. Berikut adalah panduan langkah demi langkah menggunakan bahan rumahan sebelum memanggil teknisi profesional.',
                'featured_image' => 'https://images.unsplash.com/photo-1584622650111-993a426fbf0a?w=1200&q=80',
                'author' => 'RooterIn Expert',
                'status' => 'published',
            ],
            [
                'title' => '5 Tanda Pipa Pembuangan Anda Mulai Berkerak',
                'slug' => '5-tanda-pipa-pembuangan-anda-mulai-berkerak',
                'category' => 'Tips Hemat',
                'content' => 'Kenali tanda-tanda awal sebelum pipa benar-benar mampet total dan merusak lantai Anda.',
                'featured_image' => 'https://images.unsplash.com/photo-1585955123058-930415956a69?w=800&q=80',
                'author' => 'RooterIn Expert',
                'status' => 'published',
            ],
            [
                'title' => 'Mengapa Grease Trap Penting Untuk Restoran?',
                'slug' => 'mengapa-grease-trap-penting-untuk-restoran',
                'category' => 'Pipa Industri',
                'content' => 'Untuk pemilik bisnis kuliner, menjaga aliran pipa adalah kunci kelancaran operasional harian.',
                'featured_image' => 'https://images.unsplash.com/photo-1521207418485-99c705420785?w=800&q=80',
                'author' => 'RooterIn Expert',
                'status' => 'published',
            ],
            [
                'title' => 'Bahaya Menggunakan Soda Api Pada Pipa PVC',
                'slug' => 'bahaya-menggunakan-soda-api-pada-pipa-pvc',
                'category' => 'Kamar Mandi',
                'content' => 'Banyak yang mengira soda api adalah solusi, padahal bisa berakibat fatal bagi pipa plastik.',
                'featured_image' => 'https://images.unsplash.com/photo-1621905251189-08b45d6a269e?w=800&q=80',
                'author' => 'RooterIn Expert',
                'status' => 'published',
            ],
        ];
        foreach ($posts as $post) {
            \App\Models\Post::create($post);
        }

        // --- Services Seeder ---
        $services = [
            [
                'name' => 'Pelancaran Pipa Mampet',
                'slug' => 'pelancaran-pipa-mampet',
                'icon' => 'ri-drop-line',
                'description_short' => 'Melancarkan pipa wastafel, kamar mandi, dan saluran air tanpa bongkar.',
                'description_full' => 'Layanan pelancaran pipa mampet menggunakan teknologi modern.',
                'price' => 250000,
            ],
            [
                'name' => 'Deteksi Pipa Bocor',
                'slug' => 'deteksi-pipa-bocor',
                'icon' => 'ri-radar-line',
                'description_short' => 'Deteksi titik kebocoran pipa dalam tanah atau dinding secara akurat.',
                'description_full' => 'Menggunakan alat ultrasonik dan thermal imaging.',
                'price' => 500000,
            ],
        ];
        foreach ($services as $service) {
            \App\Models\Service::create($service);
        }
    }
}
