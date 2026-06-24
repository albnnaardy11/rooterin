<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Project;

class ProjectSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $projects = [
            ['img' => 'https://images.unsplash.com/photo-1542013936693-884638332954?w=800&fit=crop', 'title' => 'Pipa Dapur Mampet', 'category' => 'Residential', 'location' => 'Denpasar'],
            ['img' => 'https://images.unsplash.com/photo-1584622650111-993a426fbf0a?w=800&fit=crop', 'title' => 'Saluran Air Kamar Mandi', 'category' => 'Residential', 'location' => 'Badung'],
            ['img' => 'https://images.unsplash.com/photo-1521207418485-99c705420785?w=800&fit=crop', 'title' => 'Wastafel Kantor', 'category' => 'Commercial', 'location' => 'Jimbaran'],
            ['img' => 'https://images.unsplash.com/photo-1504148455328-c376907d081c?w=800&fit=crop', 'title' => 'Pengerjaan Rooter Spiral', 'category' => 'Commercial', 'location' => 'Kuta'],
            ['img' => 'https://images.unsplash.com/photo-1621905251189-08b45d6a269e?w=800&fit=crop', 'title' => 'Pipa Mampet Gedung', 'category' => 'Commercial', 'location' => 'Ubud'],
            ['img' => 'https://images.unsplash.com/photo-1531973576160-7125cd663d86?w=800&fit=crop', 'title' => 'Kerja Tim Profesional', 'category' => 'Residential', 'location' => 'Sanur'],
        ];

        foreach ($projects as $project) {
            Project::create([
                'title' => $project['title'],
                'category' => $project['category'],
                'location' => $project['location'],
                'images' => [$project['img']],
            ]);
        }
    }
}
