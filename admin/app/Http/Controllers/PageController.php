<?php

namespace App\Http\Controllers;

use App\Http\Requests\SubmitAuditLeadRequest;
use App\Http\Requests\SubmitCeeLeadRequest;
use App\Http\Requests\SubmitContactMessageRequest;
use App\Models\GeneralSetting;
use App\Models\Post;
use App\Models\PostCategory;
use App\Models\SitePage;
use App\Services\Contact\ContactSubmissionService;
use App\Services\Lead\AuditLeadService;
use App\Services\Lead\CeeLeadService;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class PageController extends Controller
{
    public function show(string $slug = 'accueil')
    {
        $page = SitePage::where('slug', $slug)
            ->where('is_published', true)
            ->firstOrFail();

        $bricks = \App\Services\ContentBrickAdapter::buildBricks($slug);

        return view('front.page', compact('page', 'bricks'));
    }

    public function blog()
    {
        $posts = Post::where('status', 'published')
            ->with('category')
            ->orderByDesc('published_at')
            ->paginate(20);

        $categories = PostCategory::where('is_active', true)
            ->withCount(['posts' => fn ($q) => $q->where('status', 'published')])
            ->orderBy('order')
            ->get();

        return view('front.blog', compact('posts', 'categories'));
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

        $seoTitle = $post->meta_title ?: ($post->title . ' — NeoGTB');
        $seoDescription = $post->meta_description ?: $post->excerpt;

        $ogImageRaw = $post->og_image ?: $post->featured_image;
        if ($ogImageRaw) {
            $seoOgImage = str_starts_with($ogImageRaw, '/') || str_starts_with($ogImageRaw, 'http')
                ? $ogImageRaw
                : asset('storage/' . $ogImageRaw);
        } else {
            $seoOgImage = '/images/og-neogtb.png';
        }

        $seoUrl = route('front.article', $post->slug);

        $seoOgType = 'article';

        return view('front.article', compact(
            'post', 'related',
            'seoTitle', 'seoDescription', 'seoOgImage', 'seoUrl', 'seoOgType'
        ));
    }

    public function sendContact(Request $request, ContactSubmissionService $service)
    {
        // Honeypot anti-bot : si le champ leurre est rempli, on simule un succes
        // sans creer de message ni declencher la validation.
        if (filled($request->input('_gotcha'))) {
            return back()->with('contact_success', true);
        }

        $rules = (new SubmitContactMessageRequest())->rules();
        $messages = (new SubmitContactMessageRequest())->messages();

        $validated = Validator::make($request->all(), $rules, $messages)->validate();

        // On retire le consentement RGPD (deja valide, inutile en BDD)
        unset($validated['consentement_rgpd']);

        $service->submit(
            $validated,
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
