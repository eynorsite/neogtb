<?php

namespace App\Http\Controllers;

use App\Models\SitePage;
use App\Models\SiteSetting;

class StaticPageController extends Controller
{
    public function accueil()
    {
        $page = SitePage::where('slug', 'accueil')->firstOrFail();
        $bricks = $page->visibleBricks()->get();
        $settings = SiteSetting::getAllCached();

        return view('front.page', compact('page', 'bricks', 'settings'));
    }
    /**
     * Helper : construit le tableau SEO (title, description, og image, url canonique)
     * injecté dans chaque vue statique. Les titles/descriptions sont uniques et
     * optimisés (50-60 / 150-160 caractères) pour NeoGTB.
     */
    private function seo(string $title, string $description, ?string $ogImage = null): array
    {
        return [
            'seoTitle'       => $title,
            'seoDescription' => $description,
            'seoOgImage'     => $ogImage ?: '/images/og-neogtb.png',
            'seoUrl'         => url()->current(),
        ];
    }

    public function about()
    {
        return view('front.about', $this->seo(
            'À propos — Ulrich Calmo, consultant GTB indépendant | NeoGTB',
            'Ulrich Calmo, fondateur de NeoGTB, consultant GTB indépendant basé à Bordeaux. Zéro lien fabricant, zéro commission, zéro revente de données.'
        ));
    }

    public function faq()
    {
        return view('front.faq', $this->seo(
            'FAQ GTB — Questions fréquentes sur le décret BACS & NeoGTB',
            'Réponses aux questions fréquentes sur la GTB, le décret BACS 2027/2030, le pré-diagnostic ISO 52120-1 et le modèle d’indépendance NeoGTB.'
        ));
    }

    public function contact()
    {
        return view('front.contact', $this->seo(
            'Contact — Avis GTB indépendant sous 48h | NeoGTB Bordeaux',
            'Contactez NeoGTB pour un avis GTB indépendant sur votre projet tertiaire. Consultant basé à Bordeaux, réponse garantie sous 48h ouvrées.'
        ));
    }

    public function reglementation()
    {
        return view('front.reglementation', $this->seo(
            'Réglementation GTB — Décret BACS, Tertiaire, RE2020',
            'Décret BACS 2027/2030, décret tertiaire, RE2020, directive EPBD, ISO 52120-1 : calendrier, seuils et obligations GTB pour les bâtiments tertiaires.'
        ));
    }

    public function positionnement()
    {
        return view('front.positionnement', $this->seo(
            'Pourquoi NeoGTB — Conseil GTB 100 % indépendant, sans commission',
            'NeoGTB n’est lié à aucun fabricant : zéro commission, zéro affiliation, zéro revente de données. Découvrez les preuves concrètes de notre indépendance.'
        ));
    }

    public function gtb()
    {
        return view('front.gtb', $this->seo(
            'Qu’est-ce que la GTB ? 4 niveaux ISO 52120-1 | NeoGTB',
            'Guide complet GTB 2026 : définition, 4 niveaux ISO 52120-1 (ex-EN 15232), protocoles BACnet/KNX/Modbus, décret BACS et obligations réglementaires.'
        ));
    }

    public function gtc()
    {
        return view('front.gtc', $this->seo(
            'Qu’est-ce que la GTC ? Différences avec la GTB | NeoGTB',
            'Guide GTC : définition, différences clés avec la GTB, architecture type, protocoles OPC-UA, BACnet, Modbus et supervision multi-sites expliqués simplement.'
        ));
    }

    public function solutions()
    {
        return view('front.solutions', $this->seo(
            'Solutions GTB : protocoles BACnet, KNX, Modbus, LON — Comparatif',
            'Comparatif indépendant des protocoles GTB (BACnet, KNX, Modbus, LON), capteurs et automates. Guide technique sans lien commercial ni affiliation.'
        ));
    }

    public function mentionsLegales()
    {
        return view('front.mentions-legales', $this->seo(
            'Mentions légales — NeoGTB.fr',
            'Mentions légales de NeoGTB.fr : éditeur, directeur de publication, hébergeur, propriété intellectuelle et conditions générales d’utilisation du site.'
        ));
    }

    public function politiqueConfidentialite()
    {
        return view('front.politique-de-confidentialite', $this->seo(
            'Politique de confidentialité — RGPD | NeoGTB',
            'Comment NeoGTB collecte, utilise et protège vos données personnelles conformément au RGPD. Finalités, durées de conservation et vos droits détaillés.'
        ));
    }

    public function mesDroitsRgpd()
    {
        return view('front.mes-droits-rgpd', $this->seo(
            'Vos droits RGPD — Accès, rectification, suppression | NeoGTB',
            'Exercez vos droits RGPD sur NeoGTB : accès, rectification, suppression, portabilité, opposition et limitation. Réponse garantie sous 30 jours.'
        ));
    }

    public function newsletterConfirmee()
    {
        return view('front.newsletter-confirmee', $this->seo(
            'Inscription confirmée — Veille GTB mensuelle | NeoGTB',
            'Votre inscription à la veille GTB mensuelle NeoGTB est confirmée. Vous recevrez chaque mois une analyse indépendante du secteur GTB et du décret BACS.'
        ));
    }

    public function audit()
    {
        return view('front.audit', $this->seo(
            'Pré-diagnostic GTB gratuit — Évaluez en 5 min | Décret BACS',
            'Pré-diagnostic GTB gratuit en 5 minutes : évaluez la conformité décret BACS de votre bâtiment, estimez vos économies et recevez un rapport ISO 52120-1.'
        ));
    }

    public function comparateur()
    {
        return view('front.comparateur', $this->seo(
            'Comparateur GTB indépendant — Schneider, Siemens, Honeywell',
            'Comparez 10+ solutions GTB : Schneider, Siemens Desigo, Honeywell Niagara, Sauter, Wago, Wattsense. Comparatif 100 % indépendant, sans commission.'
        ));
    }

    public function generateurCee()
    {
        return view('front.generateur-cee', $this->seo(
            'Simulateur CEE GTB — Estimez vos primes BAT-TH-116 | NeoGTB',
            'Estimez vos Certificats d’Économies d’Énergie (CEE BAT-TH-116) pour un projet GTB en 3 minutes. Outil gratuit, indépendant, sans lien commercial.'
        ));
    }

    public function tablesModbus()
    {
        return view('front.tables-modbus', $this->seo(
            'Tables Modbus — 19 équipements GTB | NeoGTB',
            'Catalogue technique des registres Modbus pour 19 équipements GTB : compteurs, PAC, CTA, chaudières, sondes, vannes, éclairage. Données à vérifier fabricant.'
        ));
    }

    public function cookies()
    {
        return view('front.cookies', $this->seo(
            'Politique cookies — NeoGTB n’utilise aucun cookie traceur',
            'NeoGTB n’utilise aucun cookie traceur ni publicitaire. Analytics Plausible sans cookie, exempt CNIL. Seuls des cookies techniques Laravel (session, CSRF).'
        ));
    }
}
