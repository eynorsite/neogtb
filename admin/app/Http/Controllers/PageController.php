<?php

namespace App\Http\Controllers;

use App\Http\Requests\SubmitAuditLeadRequest;
use App\Http\Requests\SubmitCeeLeadRequest;
use App\Http\Requests\SubmitContactMessageRequest;
use App\Models\Post;
use App\Models\PostCategory;
use App\Models\SitePage;
use App\Models\SiteSetting;
use App\Services\Contact\ContactSubmissionService;
use App\Services\Lead\AuditLeadService;
use App\Services\Lead\CeeLeadService;

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
            ->paginate(12);

        $categories = PostCategory::where('is_active', true)
            ->withCount(['posts' => fn ($q) => $q->where('status', 'published')])
            ->orderBy('order')
            ->get();

        $settings = SiteSetting::getAllCached();

        return view('front.blog', compact('posts', 'categories', 'settings'));
    }

    public function article(string $slug)
    {
        $post = Post::where('slug', $slug)
            ->where('status', 'published')
            ->with(['category', 'tags'])
            ->firstOrFail();

        $post->increment('views_count');
        $related = Post::where('status', 'published')
            ->where('id', '!=', $post->id)
            ->where('category_id', $post->category_id)
            ->latest('published_at')
            ->limit(3)
            ->get();

        $settings = SiteSetting::getAllCached();

        return view('front.article', compact('post', 'related', 'settings'));
    }

    public function sendContact(SubmitContactMessageRequest $request, ContactSubmissionService $service)
    {
        $service->submit(
            $request->validated(),
            hash('sha256', $request->ip()),
            $request->userAgent()
        );

        return back()->with('contact_success', true);
    }

    public function storeAuditLead(SubmitAuditLeadRequest $request, AuditLeadService $service)
    {
        $service->submit(
            $request->validated(),
            hash('sha256', $request->ip()),
            $request->userAgent()
        );

        return response()->json(['status' => 'ok']);
    }

    public function storeCeeLead(SubmitCeeLeadRequest $request, CeeLeadService $service)
    {
        $service->submit(
            $request->validated(),
            hash('sha256', $request->ip()),
            $request->userAgent()
        );

        return response()->json(['status' => 'ok']);
    }
}
