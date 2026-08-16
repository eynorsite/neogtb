<?php

namespace App\Http\Controllers;

use App\Http\Requests\SubmitAuditLeadRequest;
use App\Http\Requests\SubmitCctpLeadRequest;
use App\Http\Requests\SubmitCeeLeadRequest;
use App\Http\Requests\SubmitContactMessageRequest;
use App\Models\Post;
use App\Models\PostCategory;
use App\Models\SitePage;
use App\Services\Contact\ContactSubmissionService;
use App\Services\ContentBrickAdapter;
use App\Services\Lead\AuditLeadService;
use App\Services\Lead\CctpLeadService;
use App\Services\Lead\CeeLeadService;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Validator;

class PageController extends Controller
{
    public function show(string $slug = 'accueil')
    {
        $page = SitePage::where('slug', $slug)
            ->where('is_published', true)
            ->firstOrFail();

        $bricks = ContentBrickAdapter::buildBricks($slug);

        return view('front.page', compact('page', 'bricks'));
    }

    public function blog()
    {
        $posts = Post::where('status', 'published')
            // Optimisation (Bolt) : Eager load category et tags pour éviter le problème N+1
            // causé par l'accès à ces relations dans la boucle du template front.blog.blade.php
            ->with(['category', 'tags'])
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
            // Optimisation (Bolt) : Eager load de author, en plus de category et tags,
            // pour éviter une requête supplémentaire dans front.article.blade.php
            ->with(['category', 'tags', 'author'])
            ->firstOrFail();

        // Compteur de vues incrémenté via le Query Builder, et non par
        // $post->increment() : la version Eloquent touche updated_at, si bien que
        // CHAQUE consultation d'un article changeait son <lastmod> dans le sitemap.
        // Le signal annonçait « contenu modifié » là où il ne s'était rien passé
        // d'autre qu'une visite — exactement la perte de crédibilité que la
        // fiabilisation du sitemap vise à éviter.
        DB::table('posts')->where('id', $post->id)->increment('views_count');
        // L'instance en mémoire ne reçoit pas l'incrément du Query Builder : on la
        // synchronise pour que le compteur affiché sous l'article inclue la visite
        // en cours, comme avec l'ancien increment() Eloquent.
        $post->views_count = (int) $post->views_count + 1;

        $related = Post::where('status', 'published')
            ->where('id', '!=', $post->id)
            ->where('category_id', $post->category_id)
            // Optimisation (Bolt) : Eager load de category pour prévenir le problème N+1
            // lors de l'accès à $rel->category->name pour chaque article lié
            ->with('category')
            ->latest('published_at')
            ->limit(3)
            ->get();

        $seoTitle = $post->meta_title ?: ($post->title.' - NeoGTB');
        $seoDescription = $post->meta_description ?: $post->excerpt;

        $ogImageRaw = $post->og_image ?: $post->featured_image;
        if ($ogImageRaw) {
            $seoOgImage = str_starts_with($ogImageRaw, '/') || str_starts_with($ogImageRaw, 'http')
                ? $ogImageRaw
                : asset('storage/'.$ogImageRaw);
        } else {
            $seoOgImage = '/images/og-neogtb.png';
        }

        $seoUrl = route('front.article', $post->slug);

        $seoOgType = 'article';

        // Fil d'Ariane à 3 niveaux : Accueil > Perspectives > article.
        // Sans ce maillon, le BreadcrumbList annonçait l'article comme un enfant direct
        // de la racine, ce qui aplatit la hiérarchie du site aux yeux des moteurs.
        $seoBreadcrumbName = $post->title;
        $seoBreadcrumbParent = ['name' => 'Perspectives', 'url' => route('front.blog')];

        return view('front.article', compact(
            'post', 'related',
            'seoTitle', 'seoDescription', 'seoOgImage', 'seoUrl', 'seoOgType',
            'seoBreadcrumbName', 'seoBreadcrumbParent'
        ));
    }

    public function sendContact(Request $request, ContactSubmissionService $service)
    {
        // Honeypot anti-bot : si le champ leurre est rempli, on simule un succes
        // sans creer de message ni declencher la validation.
        if (filled($request->input('_gotcha'))) {
            return back()->with('contact_success', true);
        }

        $rules = (new SubmitContactMessageRequest)->rules();
        $messages = (new SubmitContactMessageRequest)->messages();

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

    /**
     * Lead magnet : enregistre le lead puis sert le modèle de CCTP décret BACS (.docx).
     * Le fichier vit hors webroot (resources/) pour que le téléchargement passe par ce gating.
     */
    public function downloadCctpModele(SubmitCctpLeadRequest $request, CctpLeadService $service)
    {
        $service->submit(
            $request->validated(),
            hash('sha256', $request->ip())
        );

        $path = resource_path('lead-magnets/modele-cctp-decret-bacs-neogtb.docx');
        abort_unless(is_file($path), 404);

        return response()->download($path, 'modele-cctp-decret-bacs-neogtb.docx');
    }
}
