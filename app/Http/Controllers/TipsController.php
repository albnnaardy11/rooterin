<?php

namespace App\Http\Controllers;

use App\Models\Post;
use Illuminate\Http\Request;

class TipsController extends Controller
{
    public function index()
    {
        $posts = Post::where('status', 'published')->latest()->get()->map(function($post) {
            return [
                'title' => $post->title,
                'slug' => $post->slug,
                'excerpt' => \Illuminate\Support\Str::limit($post->content, 150),
                'category' => $post->category,
                'readTime' => ceil(str_word_count($post->content) / 200) . ' min read',
                'img' => $post->featured_image,
                'date' => $post->created_at->format('d M Y'),
                'featured' => (bool)$post->is_featured,
            ];
        });
        
        return view('tips', compact('posts'));
    }

    public function show($slug)
    {
        $post = Post::where('slug', $slug)->firstOrFail();
        return view('tips-detail', compact('post'));
    }
}
