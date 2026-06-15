<?php

namespace App\Http\Controllers;

use App\Models\SitePage;

class StaticPageController extends Controller
{
    /**
     * SEO par défaut des pages statiques (rendues par une vue Blade figée).
     * Titres/descriptions optimisés (50-60 / 150-160 caractères) pour NeoGTB.
     *
     * SOURCE UNIQUE : utilisée comme repli par self::seo() ET comme valeurs de
     * référence par la migration d'alignement des SitePage.meta_*. Toute mise à
     * jour d'un titre se fait ici (puis réaligner la base si nécessaire).
     */
    public const DEFAULT_SEO = [
        'about' => [
            'title'       => "À propos, Ulrich Calmo, consultant GTB indépendant | NeoGTB",
            'description' => "Ulrich Calmo, fondateur de NeoGTB, consultant GTB indépendant basé à Bordeaux. Zéro lien fabricant, zéro commission, zéro revente de données.",
        ],
        'faq' => [
            'title'       => "FAQ GTB, Questions fréquentes sur le décret BACS & NeoGTB",
            'description' => "Réponses aux questions fréquentes sur la GTB, le décret BACS, le pré-diagnostic ISO 52120-1 et le modèle d'indépendance NeoGTB.",
        ],
        'contact' => [
            'title'       => "Contact, Avis GTB indépendant sous 48h | NeoGTB Bordeaux",
            'description' => "Contactez NeoGTB pour un avis GTB indépendant sur votre projet tertiaire. Consultant basé à Bordeaux, réponse garantie sous 48h ouvrées.",
        ],
        'reglementation' => [
            'title'       => "Réglementation GTB, Décret BACS, Tertiaire, RE2020",
            'description' => "Décret BACS, décret tertiaire, RE2020, directive EPBD, ISO 52120-1 : calendrier, seuils et obligations GTB pour les bâtiments tertiaires.",
        ],
        // Slug ET title volontairement SANS année (éviter la péremption).
        'decret-bacs' => [
            'title'       => "Décret BACS : qui est concerné, échéances, mise en conformité | NeoGTB",
            'description' => "Décret BACS : GTB de classe B obligatoire (NF EN ISO 52120-1). Bâtiments concernés, échéances, dérogation TRI > 6 ans, CEE BAT-TH-116 et accompagnement indépendant.",
        ],
        'amo-gtb-gtc' => [
            'title'       => "AMO GTB/GTC, Assistance maîtrise d'ouvrage indépendante | NeoGTB",
            'description' => "Assistance à maîtrise d'ouvrage (AMO) GTB/GTC : cahier des charges, appel d'offres, suivi de chantier et réception. Conseil indépendant, sans lien fabricant.",
        ],
        // Slug ET title volontairement SANS année (éviter la péremption).
        'offres' => [
            'title'       => "Offres NeoGTB, Conseil GTB/GTC indépendant sur devis",
            'description' => "Nos offres d'accompagnement GTB/GTC : du cadrage de projet au pilotage. Conseil indépendant, sans commission. Réponse sous 48h, devis sur mesure.",
        ],
        'offre-conformite-continue' => [
            'title'       => "Audit BACS, suivi énergétique & OPERAT | NeoGTB",
            'description' => "Audit de conformité décret BACS, suivi énergétique et accompagnement OPERAT annuel pour votre bâtiment tertiaire. Conseil GTB indépendant, sans commission.",
        ],
        'positionnement' => [
            'title'       => "Pourquoi NeoGTB, Conseil GTB 100 % indépendant, sans commission",
            'description' => "NeoGTB n'est lié à aucun fabricant : zéro commission, zéro affiliation, zéro revente de données. Découvrez les preuves concrètes de notre indépendance.",
        ],
        'gtb' => [
            'title'       => "Qu'est-ce que la GTB ? 4 niveaux ISO 52120-1 | NeoGTB",
            'description' => "Guide complet GTB 2026 : définition, 4 niveaux ISO 52120-1 (ex-EN 15232), protocoles BACnet/KNX/Modbus, décret BACS et obligations réglementaires.",
        ],
        'gtc' => [
            'title'       => "Qu'est-ce que la GTC ? Différences avec la GTB | NeoGTB",
            'description' => "Guide GTC : définition, différences clés avec la GTB, architecture type, protocoles OPC-UA, BACnet, Modbus et supervision multi-sites expliqués simplement.",
        ],
        'solutions' => [
            'title'       => "Solutions GTB : protocoles BACnet, KNX, Modbus, LON, Comparatif",
            'description' => "Comparatif indépendant des protocoles GTB (BACnet, KNX, Modbus, LON), capteurs et automates. Guide technique sans lien commercial ni affiliation.",
        ],
        'mentions-legales' => [
            'title'       => "Mentions légales - NeoGTB.fr",
            'description' => "Mentions légales de NeoGTB.fr : éditeur, directeur de publication, hébergeur, propriété intellectuelle et conditions générales d'utilisation du site.",
        ],
        'politique-de-confidentialite' => [
            'title'       => "Politique de confidentialité, RGPD | NeoGTB",
            'description' => "Comment NeoGTB collecte, utilise et protège vos données personnelles conformément au RGPD. Finalités, durées de conservation et vos droits détaillés.",
        ],
        'mes-droits-rgpd' => [
            'title'       => "Vos droits RGPD, Accès, rectification, suppression | NeoGTB",
            'description' => "Exercez vos droits RGPD sur NeoGTB : accès, rectification, suppression, portabilité, opposition et limitation. Réponse garantie sous 30 jours.",
        ],
        'newsletter-confirmee' => [
            'title'       => "Inscription confirmée, Veille GTB mensuelle | NeoGTB",
            'description' => "Votre inscription à la veille GTB mensuelle NeoGTB est confirmée. Vous recevrez chaque mois une analyse indépendante du secteur GTB et du décret BACS.",
        ],
        'audit' => [
            'title'       => "Pré-diagnostic GTB gratuit, Évaluez en 5 min | Décret BACS",
            'description' => "Pré-diagnostic GTB gratuit en 5 minutes : évaluez la conformité décret BACS de votre bâtiment, estimez vos économies et recevez un rapport ISO 52120-1.",
        ],
        'comparateur' => [
            'title'       => "Comparateur GTB indépendant, Schneider, Siemens, Honeywell",
            'description' => "Comparez 10+ solutions GTB : Schneider, Siemens Desigo, Honeywell Niagara, Sauter, Wago, Wattsense. Comparatif 100 % indépendant, sans commission.",
        ],
        'generateur-cee' => [
            'title'       => "Simulateur CEE GTB, Estimez vos primes BAT-TH-116 | NeoGTB",
            'description' => "Estimez vos Certificats d'Économies d'Énergie (CEE BAT-TH-116) pour un projet GTB en 3 minutes. Outil gratuit, indépendant, sans lien commercial.",
        ],
        'tables-modbus' => [
            'title'       => "Tables Modbus, 19 équipements GTB | NeoGTB",
            'description' => "Catalogue technique des registres Modbus pour 19 équipements GTB : compteurs, PAC, CTA, chaudières, sondes, vannes, éclairage. Données à vérifier fabricant.",
        ],
        'cookies' => [
            'title'       => "Politique cookies - NeoGTB n'utilise aucun cookie traceur",
            'description' => "NeoGTB n'utilise aucun cookie traceur ni publicitaire. Analytics Plausible sans cookie, exempt CNIL. Seuls des cookies techniques Laravel (session, CSRF).",
        ],
    ];

    public function accueil()
    {
        $page = SitePage::where('slug', 'accueil')->firstOrFail();
        $bricks = \App\Services\ContentBrickAdapter::buildBricks('accueil');

        return view('front.page', compact('page', 'bricks'));
    }

    /**
     * Construit le tableau SEO injecté dans une vue statique.
     *
     * La saisie admin (SitePage.meta_*) prend le pas sur le défaut optimisé,
     * UNIQUEMENT si elle est renseignée (repli filled() : un champ vide ne doit
     * jamais écraser un bon titre). Sinon on sert le défaut de self::DEFAULT_SEO.
     */
    private function seo(string $slug, ?string $ogImage = null): array
    {
        $default = self::DEFAULT_SEO[$slug] ?? ['title' => config('app.name'), 'description' => ''];

        $sp = SitePage::where('slug', $slug)->where('is_published', true)->first();

        return [
            'seoTitle'       => filled($sp?->meta_title) ? $sp->meta_title : $default['title'],
            'seoDescription' => filled($sp?->meta_description) ? $sp->meta_description : $default['description'],
            'seoOgImage'     => $ogImage ?: '/images/og-neogtb.png',
            'seoUrl'         => url()->current(),
        ];
    }

    public function about()
    {
        return view('front.about', $this->seo('about'));
    }

    public function faq()
    {
        return view('front.faq', $this->seo('faq'));
    }

    public function contact()
    {
        return view('front.contact', $this->seo('contact'));
    }

    public function reglementation()
    {
        return view('front.reglementation', $this->seo('reglementation'));
    }

    public function decretBacs()
    {
        return view('front.decret-bacs', $this->seo('decret-bacs'));
    }

    public function amoGtbGtc()
    {
        return view('front.amo-gtb-gtc', $this->seo('amo-gtb-gtc'));
    }

    public function offres()
    {
        return view('front.offres', $this->seo('offres'));
    }

    public function offreConformiteContinue()
    {
        return view('front.offre-conformite-continue', $this->seo('offre-conformite-continue'));
    }

    public function positionnement()
    {
        return view('front.positionnement', $this->seo('positionnement'));
    }

    public function gtb()
    {
        return view('front.gtb', $this->seo('gtb'));
    }

    public function gtc()
    {
        return view('front.gtc', $this->seo('gtc'));
    }

    public function solutions()
    {
        return view('front.solutions', $this->seo('solutions'));
    }

    public function mentionsLegales()
    {
        return view('front.mentions-legales', $this->seo('mentions-legales'));
    }

    public function politiqueConfidentialite()
    {
        return view('front.politique-de-confidentialite', $this->seo('politique-de-confidentialite'));
    }

    public function mesDroitsRgpd()
    {
        return view('front.mes-droits-rgpd', $this->seo('mes-droits-rgpd'));
    }

    public function newsletterConfirmee()
    {
        return view('front.newsletter-confirmee', $this->seo('newsletter-confirmee'));
    }

    public function audit()
    {
        return view('front.audit', $this->seo('audit'));
    }

    public function comparateur()
    {
        return view('front.comparateur', $this->seo('comparateur'));
    }

    public function generateurCee()
    {
        return view('front.generateur-cee', $this->seo('generateur-cee'));
    }

    public function tablesModbus()
    {
        return view('front.tables-modbus', $this->seo('tables-modbus'));
    }

    public function cookies()
    {
        return view('front.cookies', $this->seo('cookies'));
    }
}
