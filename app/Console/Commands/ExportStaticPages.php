<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use Illuminate\Support\Facades\Request;
use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\URL;

class ExportStaticPages extends Command
{
    protected $signature = 'export:static';
    protected $description = 'Export Blade views to static HTML files for GitHub Pages';

    public function handle()
    {
        // Force production environment to ensure Vite uses built assets
        putenv('APP_ENV=production');
        config(['app.env' => 'production']);

        // Temporarily remove hot file if it exists
        $hotFile = public_path('hot');
        $hotFileBackup = public_path('hot.bak');
        if (file_exists($hotFile)) {
            rename($hotFile, $hotFileBackup);
        }
        
        $pages = [
            '/' => 'index.html',
            '/tentang' => 'about.html',
            '/layanan' => 'layanan.html',
            '/galeri' => 'galeri.html',
            '/tips' => 'tips.html',
            '/ai-diagnostic' => 'ai-diagnostic.html',
            '/wiki' => 'wiki.html',
            '/kontak' => 'kontak.html',
        ];

        $baseUrl = config('app.url', 'http://localhost');
        $this->info("Base URL: $baseUrl");

        foreach ($pages as $uri => $filename) {
            $this->info("Exporting $uri to $filename...");
            
            // Generate full URL
            $url = $baseUrl . $uri;
            
            // Use file_get_contents to hit the running server or use internal rendering
            // Internal rendering is better to avoid network issues
            try {
                // Mock request
                $request = \Illuminate\Http\Request::create($uri, 'GET');
                app()->instance('request', $request);
                
                // Get the response
                $response = app()->make(\Illuminate\Contracts\Http\Kernel::class)->handle($request);
                $html = $response->getContent();
                
                $html = $this->postProcessHtml($html, $baseUrl);

                // Save to docs
                if (!is_dir(base_path('docs'))) {
                    mkdir(base_path('docs'), 0755, true);
                }
                file_put_contents(base_path('docs/' . $filename), $html);
                
                $this->info("Successfully exported $filename");
            } catch (\Exception $e) {
                $this->error("Failed to export $uri: " . $e->getMessage());
            }
        }

        $this->info("Copying assets...");
        $this->copyDirectory(public_path('build'), base_path('docs/build'));
        
        // Post-process build assets (JS and CSS)
        $this->info("Post-processing build assets...");
        $buildFiles = array_merge(
            glob(base_path('docs/build/assets/*.css')),
            glob(base_path('docs/build/assets/*.js'))
        );
        
        foreach ($buildFiles as $file) {
            $content = file_get_contents($file);
            
            // Fix absolute paths in build assets
            // This replaces paths starting with /build/ and /assets/
            $replacements = [
                '/build/assets/' => '',
                '/assets/' => '../../assets/', // Relative from build/assets/ to public/assets/
            ];
            
            foreach ($replacements as $search => $replace) {
                // Handle various quoting styles in JS/CSS
                $content = str_replace(
                    ['url("'.$search, "url('".$search, 'url('.$search, '"'.$search, "'".$search],
                    ['url("'.$replace, "url('".$replace, 'url('.$replace, '"'.$replace, "'".$replace],
                    $content
                );
            }
            
            // Specialized fixes for remixicon and other fonts in CSS
            if (pathinfo($file, PATHINFO_EXTENSION) === 'css') {
                // Ensure plain url(/build/assets/...) becomes url(...)
                $content = preg_replace('/url\(\s*[\'"]?\/build\/assets\//', 'url(', $content);
            }
            
            file_put_contents($file, $content);
        }

        if (is_dir(public_path('images'))) {
            $this->copyDirectory(public_path('images'), base_path('docs/images'));
        }
        
        if (is_dir(public_path('assets'))) {
            $this->copyDirectory(public_path('assets'), base_path('docs/assets'));
        }
        
        if (is_dir(public_path('models'))) {
            $this->copyDirectory(public_path('models'), base_path('docs/models'));
        }

        if (file_exists(public_path('favicon.ico'))) {
            copy(public_path('favicon.ico'), base_path('docs/favicon.ico'));
        }

        if (file_exists(public_path('sw.js'))) {
            copy(public_path('sw.js'), base_path('docs/sw.js'));
        }

        // Restore hot file
        if (file_exists($hotFileBackup)) {
            rename($hotFileBackup, $hotFile);
        }

        $this->info("Static export completed!");
        return 0;
    }

    private function postProcessHtml($html, $baseUrl)
    {
        // 1. Remove CSRF token
        $html = preg_replace('/<meta name="csrf-token" content=".*">/', '', $html);

        // 2. Clear out absolute local URLs
        $html = str_replace($baseUrl, '', $html);
        
        // 3. Fix absolute paths to relative ones (aggressive regex for quotes)
        // Matches "/path" but not "//domain"
        $html = preg_replace('/(["\'])\/([a-zA-Z0-9_\-\.][^"\']*)\1/', '$1$2$1', $html);

        // 4. Replace known slugs with .html versions
        $pages = [
            'tentang' => 'about.html',
            'layanan' => 'layanan.html',
            'galeri' => 'galeri.html',
            'tips' => 'tips.html',
            'ai-diagnostic' => 'ai-diagnostic.html',
            'wiki' => 'wiki.html',
            'kontak' => 'kontak.html'
        ];

        foreach ($pages as $slug => $file) {
            // Match with quotes or slashes
            $html = str_replace(['"'.$slug.'"', "'".$slug."'", '"'.$slug.'/"', "'".$slug."/'"], '"'.$file.'"', $html);
        }

        // Special handling for home
        $html = str_replace(['href="/"', 'href=\'/\'', '": "/"', "': '/'"], 'href="index.html"', $html);
        $html = str_replace(['href=""', 'href=\'\''], 'href="index.html"', $html);

        // 5. Add favicon if missing
        if (!str_contains($html, 'rel="icon"')) {
            $html = str_replace('</head>', '    <link rel="icon" href="favicon.ico" type="image/x-icon">' . "\n" . '    </head>', $html);
        }

        return $html;
    }

    private function copyDirectory($src, $dst)
    {
        if (!is_dir($src)) return;
        
        if (!is_dir($dst)) {
            mkdir($dst, 0755, true);
        }

        $files = scandir($src);
        foreach ($files as $file) {
            if ($file != "." && $file != "..") {
                if (is_dir("$src/$file")) {
                    $this->copyDirectory("$src/$file", "$dst/$file");
                } else {
                    copy("$src/$file", "$dst/$file");
                }
            }
        }
    }
}
