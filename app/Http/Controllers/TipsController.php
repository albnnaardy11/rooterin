<?php

namespace App\Http\Controllers;

use App\Repositories\Contracts\PostRepositoryInterface;
use Illuminate\Http\Request;
use Illuminate\Support\Str;
use Artesaos\SEOTools\Facades\SEOTools;
use App\Services\Seo\InternalLinkService;

class TipsController extends Controller
{
    protected $postRepo;
    protected $linker;

    public function __construct(PostRepositoryInterface $postRepo, InternalLinkService $linker)
    {
        $this->postRepo = $postRepo;
        $this->linker = $linker;
    }

    public function index()
    {
        SEOTools::setTitle('Tips & Trik Saluran Mampet - Rooterin');
        SEOTools::setDescription('Kumpulan artikel bermanfaat mengenai perawatan pipa, cara mengatasi saluran mampet, dan tips sanitasi modern.');
        SEOTools::opengraph()->setUrl(url('/tips'));
        SEOTools::setCanonical(url('/tips'));

        $posts = $this->postRepo->all()->where('status', 'published')->map(function($post) {
            return [
                'title' => $post->title,
                'slug' => $post->slug,
                'excerpt' => Str::limit(strip_tags($post->content), 150),
                'category' => $post->category,
                'readTime' => ceil(str_word_count(strip_tags($post->content)) / 200) . ' min read',
                'img' => $post->featured_image,
                'date' => $post->created_at->format('d M Y'),
                'featured' => (bool)$post->is_featured,
            ];
        });
        
        return view('tips', compact('posts'));
    }

    public function show($slug)
    {
        $post = $this->postRepo->findBySlug($slug);
        
        if ($post) {
            $seo = $post->seo;
            SEOTools::setTitle($seo->title ?? $post->title);
            SEOTools::setDescription($seo->description ?? Str::limit(strip_tags($post->content), 160));
            SEOTools::opengraph()->setUrl(url("/tips/{$post->slug}"));
            SEOTools::opengraph()->addProperty('type', 'article');
            SEOTools::setCanonical(url("/tips/{$post->slug}"));
            
            if ($post->featured_image) {
                SEOTools::opengraph()->addImage(url($post->featured_image));
            }

            // Masterpiece SEO: Automatic Interlinking for authority building
            $post->content = $this->linker->automate($post->content);
        }

        return view('tips-detail', compact('post'));
    }
}
