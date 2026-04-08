@extends('front.layouts.app')

@section('title', 'Contact — Conseil GTB indépendant')
@section('description', 'Contactez NeoGTB pour un avis indépendant sur votre projet GTB. Basé à Bordeaux, réponse sous 48h.')

@push('head')
<script type="application/ld+json">
@verbatim
{"@context":"https://schema.org","@type":"ContactPage","name":"Contact NeoGTB","url":"https://neogtb.fr/contact"}
@endverbatim
</script>
@endpush

@section('content')

<x-front.shared.hero
    image="/images/hero-gtb-illustration.webp"
    imageAlt="Contacter NeoGTB"
    eyebrow="Contact"
    title="Engageons une conversation"
    highlight="conversation"
    subtitle="Un échange factuel pour comprendre votre contexte. Sans engagement, sans pitch commercial."
    :tags="['Réponse sous 24h', 'Échange gratuit']"
    :cta="['text' => 'Aller au formulaire', 'url' => '#formulaire']"
    minHeight="480px"
    overlay="gradient"
/>

<section class="relative overflow-hidden bg-white py-12 md:py-20" id="formulaire">
    <div class="max-w-7xl mx-auto px-6 md:px-10 relative z-10">
        <div class="grid md:grid-cols-2 gap-12 lg:gap-20">

            <!-- Left: Info -->
            <div class="flex flex-col justify-center">
                <div class="mt-2 space-y-5">
                    <!-- Email -->
                    <div class="flex items-center gap-4">
                        <div class="w-10 h-10 rounded-lg flex items-center justify-center bg-dark-50 border border-dark-100">
                            <svg class="w-[18px] h-[18px] text-dark-400" fill="none" stroke="currentColor" stroke-width="1.5" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" d="M21.75 6.75v10.5a2.25 2.25 0 01-2.25 2.25h-15a2.25 2.25 0 01-2.25-2.25V6.75m19.5 0A2.25 2.25 0 0019.5 4.5h-15a2.25 2.25 0 00-2.25 2.25m19.5 0v.243a2.25 2.25 0 01-1.07 1.916l-7.5 4.615a2.25 2.25 0 01-2.36 0L3.32 8.91a2.25 2.25 0 01-1.07-1.916V6.75" />
                            </svg>
                        </div>
                        <div>
                            <p class="text-[13px] text-dark-400">Email</p>
                            <a href="mailto:hello@neogtb.fr" class="text-[15px] font-medium text-dark-900 hover:text-accent-600 transition-colors">hello@neogtb.fr</a>
                        </div>
                    </div>

                    <!-- Telephone -->
                    <div class="flex items-center gap-4">
                        <div class="w-10 h-10 rounded-lg flex items-center justify-center bg-dark-50 border border-dark-100">
                            <svg class="w-[18px] h-[18px] text-dark-400" fill="none" stroke="currentColor" stroke-width="1.5" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" d="M2.25 6.75c0 8.284 6.716 15 15 15h2.25a2.25 2.25 0 002.25-2.25v-1.372c0-.516-.351-.966-.852-1.091l-4.423-1.106c-.44-.11-.902.055-1.173.417l-.97 1.293c-.282.376-.769.542-1.21.38a12.035 12.035 0 01-7.143-7.143c-.162-.441.004-.928.38-1.21l1.293-.97c.363-.271.527-.734.417-1.173L6.963 3.102a1.125 1.125 0 00-1.091-.852H4.5A2.25 2.25 0 002.25 4.5v2.25z" />
                            </svg>
                        </div>
                        <div>
                            <p class="text-[13px] text-dark-400">Téléphone</p>
                            <a href="tel:+33650143252" class="text-[15px] font-medium text-dark-900 hover:text-accent-600 transition-colors">06 50 14 32 52</a>
                        </div>
                    </div>

                    <!-- Response time -->
                    <div class="flex items-center gap-4">
                        <div class="w-10 h-10 rounded-lg flex items-center justify-center bg-dark-50 border border-dark-100">
                            <svg class="w-[18px] h-[18px] text-dark-400" fill="none" stroke="currentColor" stroke-width="1.5" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" d="M12 6v6h4.5m4.5 0a9 9 0 11-18 0 9 9 0 0118 0z" />
                            </svg>
                        </div>
                        <div>
                            <p class="text-[13px] text-dark-400">Temps de réponse</p>
                            <p class="text-[15px] font-medium text-dark-900">Sous 48h</p>
                        </div>
                    </div>
                </div>

                <!-- Trust badge -->
                <div class="mt-10 flex items-center gap-2">
                    <svg class="w-4 h-4 text-dark-300" fill="none" stroke="currentColor" stroke-width="1.5" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M9 12.75L11.25 15 15 9.75m-3-7.036A11.959 11.959 0 013.598 6 11.99 11.99 0 003 9.749c0 5.592 3.824 10.29 9 11.623 5.176-1.332 9-6.03 9-11.622 0-1.31-.21-2.571-.598-3.751h-.152c-3.196 0-6.1-1.248-8.25-3.285z" />
                    </svg>
                    <p class="text-xs text-dark-400">Tiers de confiance indépendant — aucun démarchage</p>
                </div>
            </div>

            <!-- Right: Form -->
            <div>
                <div class="rounded-xl p-6 md:p-8 bg-white border border-dark-100 shadow-sm">
                    @if(session('contact_success'))
                    <div class="p-4 rounded-lg bg-accent-50 border border-accent-200" role="alert">
                        <p class="text-sm font-medium text-accent-700">Merci pour votre demande.</p>
                        <p class="text-[13px] text-dark-500 mt-1">Nous avons bien reçu votre message et reviendrons vers vous sous 48h ouvrées.</p>
                    </div>
                    @else
                    <form
                        action="/contact/send"
                        method="POST"
                        x-data="{ sending: false }"
                        x-on:submit="sending = true"
                    >
                        @csrf
                        <input type="hidden" name="source_page" value="contact" />
                        <div class="space-y-5">

                            <div>
                                <label for="name" class="block text-[13px] font-medium text-dark-700 mb-1.5">Nom</label>
                                <input type="text" id="name" name="name" required placeholder="Votre nom"
                                    class="w-full px-4 py-2.5 text-sm text-dark-900 bg-white rounded-lg border border-dark-200 outline-none transition-all focus:border-accent-500 focus:ring-2 focus:ring-accent-50 placeholder:text-dark-300" />
                            </div>

                            <div>
                                <label for="email" class="block text-[13px] font-medium text-dark-700 mb-1.5">Email professionnel</label>
                                <input type="email" id="email" name="email" required placeholder="vous@entreprise.fr"
                                    class="w-full px-4 py-2.5 text-sm text-dark-900 bg-white rounded-lg border border-dark-200 outline-none transition-all focus:border-accent-500 focus:ring-2 focus:ring-accent-50 placeholder:text-dark-300" />
                            </div>

                            <div>
                                <label for="company" class="block text-[13px] font-medium text-dark-700 mb-1.5">
                                    Entreprise <span class="text-dark-300 font-normal">(optionnel)</span>
                                </label>
                                <input type="text" id="company" name="company" placeholder="Nom de votre entreprise"
                                    class="w-full px-4 py-2.5 text-sm text-dark-900 bg-white rounded-lg border border-dark-200 outline-none transition-all focus:border-accent-500 focus:ring-2 focus:ring-accent-50 placeholder:text-dark-300" />
                            </div>

                            <div>
                                <label for="subject" class="block text-[13px] font-medium text-dark-700 mb-1.5">Sujet</label>
                                <select id="subject" name="subject" required
                                    class="w-full px-4 py-2.5 text-sm text-dark-900 bg-white rounded-lg border border-dark-200 outline-none transition-all focus:border-accent-500 focus:ring-2 focus:ring-accent-50 appearance-none"
                                    style="background-image: url(&quot;data:image/svg+xml,%3Csvg xmlns='http://www.w3.org/2000/svg' width='16' height='16' fill='none' stroke='%239ca3af' stroke-width='1.5' viewBox='0 0 24 24'%3E%3Cpath stroke-linecap='round' stroke-linejoin='round' d='M19.5 8.25l-7.5 7.5-7.5-7.5'/%3E%3C/svg%3E&quot;); background-repeat: no-repeat; background-position: right 12px center;">
                                    <option value="" disabled selected>Choisir un sujet</option>
                                    <option value="Avis sur un devis">Avis sur un devis</option>
                                    <option value="Aide au choix technologique">Aide au choix technologique</option>
                                    <option value="Question réglementaire">Question réglementaire</option>
                                    <option value="Demande d'audit">Demande d'audit</option>
                                    <option value="Autre">Autre</option>
                                </select>
                            </div>

                            <div>
                                <label for="message" class="block text-[13px] font-medium text-dark-700 mb-1.5">Message</label>
                                <textarea id="message" name="message" rows="4" required placeholder="Décrivez votre contexte..."
                                    class="w-full px-4 py-2.5 text-sm text-dark-900 bg-white rounded-lg border border-dark-200 outline-none transition-all focus:border-accent-500 focus:ring-2 focus:ring-accent-50 resize-y placeholder:text-dark-300"></textarea>
                            </div>

                            <div>
                                <button type="submit" :disabled="sending"
                                    class="w-full inline-flex items-center justify-center gap-2 px-6 py-3 bg-primary-600 text-white text-sm font-semibold rounded-lg hover:bg-primary-700 transition-colors btn-glow disabled:opacity-50">
                                    <span x-show="!sending">Envoyer ma demande</span>
                                    <span x-show="sending" class="flex items-center gap-2">
                                        <svg class="w-4 h-4 animate-spin" fill="none" viewBox="0 0 24 24">
                                            <circle class="opacity-25" cx="12" cy="12" r="10" stroke="currentColor" stroke-width="3" />
                                            <path class="opacity-75" fill="currentColor" d="M4 12a8 8 0 018-8V0C5.373 0 0 5.373 0 12h4zm2 5.291A7.962 7.962 0 014 12H0c0 3.042 1.135 5.824 3 7.938l3-2.647z" />
                                        </svg>
                                        Envoi en cours...
                                    </span>
                                </button>
                            </div>

                            <label class="flex items-start gap-2 cursor-pointer">
                                <input type="checkbox" required class="mt-0.5 rounded border-dark-300 text-accent-600 focus:ring-accent-500" />
                                <span class="text-[11px] text-dark-400 leading-relaxed">
                                    J'accepte que mes données soient traitées par NeoGTB pour répondre à ma demande (intérêt légitime, art. 6.1.f RGPD). Conservées 3 ans. <a href="/politique-de-confidentialite" class="underline hover:text-dark-600">Politique de confidentialité</a> &middot; <a href="/mes-droits-rgpd" class="underline hover:text-dark-600">Exercer vos droits</a>
                                </span>
                            </label>

                        </div>
                    </form>
                    @endif
                </div>
            </div>

        </div>
    </div>
</section>

@endsection
