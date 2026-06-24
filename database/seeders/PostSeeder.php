<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Post;

class PostSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
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
            Post::create($post);
        }
    }
}
