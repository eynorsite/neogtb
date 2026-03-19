<?php

namespace App\Http\Controllers;

use App\Models\ContactMessage;
use App\Models\Post;
use App\Models\SitePage;
use App\Models\SiteSetting;
use Illuminate\Http\Request;

class PageController extends Controller
{
    public function show(string $slug = 'accueil')
    {
        $page = SitePage::where('slug', $slug)
            ->where('is_published', true)
            ->firstOrFail();

        $settings = SiteSetting::getAllCached();
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

    public function sendContact(Request $request)
    {
        $validated = $request->validate([
            'name' => 'required|string|max:100',
            'email' => 'required|email|max:100',
            'company' => 'nullable|string|max:100',
            'subject' => 'required|string|max:200',
            'message' => 'required|string|max:5000',
            'source_page' => 'nullable|string|max:200',
        ]);

        ContactMessage::create([
            'name' => $validated['name'],
            'email' => $validated['email'],
            'company' => $validated['company'] ?? null,
            'subject' => $validated['subject'],
            'message' => $validated['message'],
            'source_page' => $validated['source_page'] ?? null,
            'ip_address' => $request->ip(),
            'status' => 'new',
        ]);

        return back()->with('contact_success', true);
    }
}
