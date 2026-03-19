<?php

namespace App\Http\Controllers;

use App\Models\Post;
use App\Models\SitePage;
use App\Models\SiteSetting;

class PageController extends Controller
{
    public function show(string $slug = 'accueil')
    {
        $page = SitePage::where('slug', $slug)
            ->where('is_published', true)
            ->firstOrFail();

        $settings = SiteSetting::getAllCached();

        // Use dedicated template if it exists, otherwise render bricks
        $dedicatedView = 'front.' . str_replace('-', '_', $slug);
        if (view()->exists($dedicatedView)) {
            return view($dedicatedView, compact('page', 'settings'));
        }

        $bricks = $page->visibleBricks()->get();
        return view('front.page', compact('page', 'bricks', 'settings'));
    }

    public function blog()
    {
        $posts = Post::where('status', 'published')
            ->with('category')
            ->orderByDesc('published_at')
            ->paginate(9);

        $settings = SiteSetting::getAllCached();

        return view('front.blog', compact('posts', 'settings'));
    }

    public function article(string $slug)
    {
        $post = Post::where('slug', $slug)
            ->where('status', 'published')
            ->with('category')
            ->firstOrFail();

        $post->increment('views');
        $related = Post::where('status', 'published')
            ->where('id', '!=', $post->id)
            ->where('category_id', $post->category_id)
            ->limit(3)
            ->get();

        $settings = SiteSetting::getAllCached();

        return view('front.article', compact('post', 'related', 'settings'));
    }
}
