<?php

namespace App\Http\Controllers;

class StaticPageController extends Controller
{
    public function accueil()              { return view('front.accueil'); }
    public function about()                { return view('front.about'); }
    public function faq()                  { return view('front.faq'); }
    public function contact()              { return view('front.contact'); }
    public function reglementation()       { return view('front.reglementation'); }
    public function positionnement()       { return view('front.positionnement'); }
    public function gtb()                  { return view('front.gtb'); }
    public function gtc()                  { return view('front.gtc'); }
    public function solutions()            { return view('front.solutions'); }
    public function mentionsLegales()      { return view('front.mentions-legales'); }
    public function politiqueConfidentialite() { return view('front.politique-de-confidentialite'); }
    public function mesDroitsRgpd()        { return view('front.mes-droits-rgpd'); }
    public function newsletterConfirmee()  { return view('front.newsletter-confirmee'); }
    public function audit()                { return view('front.audit'); }
    public function comparateur()          { return view('front.comparateur'); }
    public function generateurCee()        { return view('front.generateur-cee'); }
}
