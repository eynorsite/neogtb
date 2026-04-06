@extends('front.layouts.app')

@section('title', 'Inscription confirmee')
@section('description', 'Votre inscription a la veille GTB mensuelle NeoGTB est confirmee.')

@section('content')

<section class="py-32 text-center">
    <div class="max-w-[600px] mx-auto px-6">
        <div class="w-16 h-16 rounded-full bg-accent-50 flex items-center justify-center mx-auto mb-6">
            <svg width="32" height="32" fill="none" stroke="currentColor" viewBox="0 0 24 24" stroke-width="2" class="text-accent-600"><path stroke-linecap="round" stroke-linejoin="round" d="M5 13l4 4L19 7"/></svg>
        </div>
        <h1 class="font-heading text-[28px] font-medium text-dark-900 tracking-tight mb-3">Inscription confirmee</h1>
        <p class="text-base text-dark-500 leading-relaxed mb-8">
            Vous recevrez la veille GTB mensuelle NeoGTB dans votre boite mail. 1 email par mois, desabonnement en 1 clic.
        </p>
        <a href="/" class="inline-flex items-center gap-2 px-6 py-3 bg-primary-600 text-white text-sm font-semibold rounded-lg hover:bg-primary-700 transition-colors btn-glow">
            Retour a l'accueil
            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7"/></svg>
        </a>
    </div>
</section>

@endsection
