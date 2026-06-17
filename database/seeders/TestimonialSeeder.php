<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Testimonial;

class TestimonialSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $testimonials = [
            ['name' => 'Bpk. Ahmad', 'photo' => 'https://i.pravatar.cc/150?u=ahmad', 'rating' => 5, 'content' => 'Layanan sangat cepat dan pipa wastafel kembali lancar tanpa dibongkar!'],
            ['name' => 'Ibu Maria', 'photo' => 'https://i.pravatar.cc/150?u=maria', 'rating' => 5, 'content' => 'Teknisinya ramah dan kerjanya sangat rapi. Sangat merekomendasikan RooterIn.'],
        ];

        foreach ($testimonials as $testimonial) {
            Testimonial::create($testimonial);
        }
    }
}
