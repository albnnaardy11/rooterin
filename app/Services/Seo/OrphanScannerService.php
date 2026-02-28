<?php

namespace App\Services\Seo;

use App\Models\WikiEntity;
use App\Models\Service;
use App\Models\Post;
use App\Models\Project;
use Illuminate\Support\Facades\DB;

class OrphanScannerService
{
    public function scan()
    {
        // 1. Collect potential targets
        $targets = [];
        
        WikiEntity::all()->each(function($w) use (&$targets) {
            $path = '/wiki/' . $w->slug;
            $targets[$path] = ['title' => $w->title, 'type' => 'Wiki Entity', 'found' => false];
        });

        Service::all()->each(function($s) use (&$targets) {
            $path = '/layanan/' . $s->slug;
            $targets[$path] = ['title' => $s->title, 'type' => 'Service', 'found' => false];
        });

        Post::all()->each(function($p) use (&$targets) {
            $path = '/tips-trik/' . $p->slug;
            $targets[$path] = ['title' => $p->title, 'type' => 'Post', 'found' => false];
        });

        // 2. Scan all contents for these paths
        $allContents = DB::table('wiki_entities')->pluck('description')->merge(
            DB::table('posts')->pluck('content')
        )->merge(
            DB::table('services')->pluck('description_full')
        )->merge(
            DB::table('services')->pluck('description_short')
        );

        foreach ($allContents as $content) {
            if (!$content) continue;
            foreach ($targets as $path => &$data) {
                if (str_contains($content, $path)) {
                    $data['found'] = true;
                }
            }
        }

        // Add menu and footer content to the scan if available via settings
        $settings = DB::table('settings')->where('key', 'like', '%content%')->pluck('value');
        foreach ($settings as $val) {
            foreach ($targets as $path => &$data) {
                if (str_contains($val, $path)) {
                    $data['found'] = true;
                }
            }
        }

        // 3. Filter only orphans
        return collect($targets)->filter(fn($t) => !$t['found'])->map(function($data, $path) {
            $data['url'] = $path;
            return $data;
        });
    }
}
