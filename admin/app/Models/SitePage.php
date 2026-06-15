<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\SoftDeletes;

class SitePage extends Model
{
    use SoftDeletes;

    protected $table = 'site_pages';

    /**
     * Slugs dont la page publique est rendue par une vue Blade FIGÉE
     * (contenu en dur dans resources/views/front/<slug>.blade.php, servie par
     * StaticPageController ou PageController), et NON depuis la table page_contents.
     *
     * Conséquence : éditer leur « contenu » dans l'admin n'aurait aucun effet
     * sur le site. Tant qu'une page n'est pas migrée en blocs dynamiques (rendue
     * par front.page), elle reste listée ici et son éditeur de contenu est masqué.
     * Retirer un slug de cette liste UNIQUEMENT après l'avoir rendu dynamique.
     *
     * NB : « accueil » n'y figure pas — il EST dynamique (front.page + bricks
     * lus depuis page_contents). Le SEO (meta_*) de ces pages reste, lui,
     * pilotable depuis l'admin (cf. StaticPageController::seo()).
     */
    public const STATICALLY_RENDERED_SLUGS = [
        'gtb', 'gtc', 'solutions', 'reglementation', 'positionnement',
        'about', 'faq', 'contact', 'audit', 'comparateur', 'generateur-cee',
        'tables-modbus', 'blog', 'newsletter-confirmee', 'cookies',
        'mentions-legales', 'politique-de-confidentialite', 'mes-droits-rgpd',
        'offre-conformite-continue',
    ];

    protected $fillable = [
        'slug', 'name', 'hero_title', 'hero_subtitle', 'hero_description',
        'hero_cta_text', 'hero_cta_url', 'hero_image',
        'meta_title', 'meta_description', 'meta_keywords',
        'og_title', 'og_description', 'og_image',
        'is_published', 'order',
    ];

    protected function casts(): array
    {
        return [
            'is_published' => 'boolean',
        ];
    }

    public function sections(): HasMany
    {
        return $this->hasMany(PageSection::class, 'page_id')->orderBy('order');
    }

    public function bricks(): HasMany
    {
        return $this->hasMany(PageBrick::class, 'page_id')->orderBy('order');
    }

    public function visibleBricks(): HasMany
    {
        return $this->hasMany(PageBrick::class, 'page_id')
            ->where('is_visible', true)
            ->orderBy('order');
    }

    /**
     * La page est-elle rendue par une vue Blade figée (contenu non éditable
     * depuis l'admin) ? Voir self::STATICALLY_RENDERED_SLUGS.
     */
    public function isStaticallyRendered(): bool
    {
        return in_array($this->slug, self::STATICALLY_RENDERED_SLUGS, true);
    }
}
