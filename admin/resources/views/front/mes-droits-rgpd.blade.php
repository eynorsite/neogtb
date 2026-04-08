@extends('front.layouts.app')


@section('content')

<section class="py-12 lg:py-24">
    <div class="max-w-[680px] mx-auto px-4 sm:px-6">

        <div class="text-center mb-12">
            <p class="text-xs font-semibold uppercase tracking-widest text-accent-600 mb-4">RGPD — Vos droits</p>
            <h1 class="font-heading font-medium text-dark-900 text-[26px] tracking-tight">Exercer vos droits RGPD</h1>
            <p class="mt-4 text-dark-500 max-w-xl mx-auto text-sm leading-relaxed">
                Conformément au RGPD, vous disposez de droits sur vos données personnelles. Sélectionnez le type de demande ci-dessous.
            </p>
        </div>

        <div class="bg-white rounded-2xl p-5 lg:p-7 border border-dark-100 lg:shadow-sm" x-data="rgpdForm()">

            <!-- Type de demande -->
            <div class="mb-8">
                <label class="block text-sm font-medium text-dark-700 mb-3">Type de demande</label>
                <div class="space-y-2">
                    @foreach([
                        ['value' => 'access', 'title' => 'Accéder à mes données', 'desc' => "Droit d'accès — Obtenir une copie de toutes vos données"],
                        ['value' => 'rectification', 'title' => 'Corriger mes données', 'desc' => 'Droit de rectification — Corriger des informations inexactes'],
                        ['value' => 'deletion', 'title' => 'Supprimer mes données', 'desc' => "Droit à l'oubli — Effacer définitivement vos données"],
                        ['value' => 'portability', 'title' => 'Exporter mes données', 'desc' => 'Droit à la portabilité — Recevoir vos données en format structuré'],
                        ['value' => 'opposition', 'title' => "M'opposer au traitement", 'desc' => "Droit d'opposition — Cesser le traitement de vos données"],
                    ] as $option)
                    <label class="flex items-start gap-3 p-3 rounded-lg cursor-pointer transition-all border border-dark-100 hover:bg-dark-50"
                        :class="form.type === '{{ $option['value'] }}' ? 'border-accent-500 bg-accent-50' : ''">
                        <input type="radio" name="type" value="{{ $option['value'] }}" x-model="form.type" class="mt-1">
                        <div>
                            <span class="font-medium text-dark-800 text-sm">{{ $option['title'] }}</span>
                            <span class="block text-xs text-dark-400 mt-0.5">{{ $option['desc'] }}</span>
                        </div>
                    </label>
                    @endforeach
                </div>
            </div>

            <!-- Champs du formulaire -->
            <div class="space-y-4 mb-8">
                <div>
                    <label class="block text-sm font-medium text-dark-700 mb-1">Votre email</label>
                    <input type="email" x-model="form.email" placeholder="votre@email.com" required
                        class="w-full px-4 py-3 rounded-lg text-sm text-dark-700 border border-dark-200 focus:ring-2 focus:ring-accent-500 focus:outline-none focus:border-accent-500">
                </div>
                <div>
                    <label class="block text-sm font-medium text-dark-700 mb-1">Votre nom</label>
                    <input type="text" x-model="form.name" placeholder="Prénom Nom" required
                        class="w-full px-4 py-3 rounded-lg text-sm text-dark-700 border border-dark-200 focus:ring-2 focus:ring-accent-500 focus:outline-none focus:border-accent-500">
                </div>
                <div>
                    <label class="block text-sm font-medium text-dark-700 mb-1">Précisions <span class="text-dark-400 font-normal">(optionnel)</span></label>
                    <textarea x-model="form.message" rows="4" placeholder="Décrivez votre demande si nécessaire..."
                        class="w-full px-4 py-3 rounded-lg text-sm text-dark-700 border border-dark-200 focus:ring-2 focus:ring-accent-500 focus:outline-none focus:border-accent-500 resize-y"></textarea>
                </div>
                <input type="text" name="_gotcha" style="display:none" tabindex="-1" autocomplete="off">
            </div>

            <!-- Info sécurité -->
            <div class="bg-accent-50 rounded-xl p-4 mb-6 border border-accent-200">
                <div class="flex gap-3">
                    <svg class="w-5 h-5 text-accent-600 flex-shrink-0 mt-0.5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 15v2m-6 4h12a2 2 0 002-2v-6a2 2 0 00-2-2H6a2 2 0 00-2 2v6a2 2 0 002 2zm10-10V7a4 4 0 00-8 0v4h8z"/></svg>
                    <div class="text-sm leading-relaxed">
                        <p class="font-medium text-accent-800">Vos données sont protégées</p>
                        <p class="text-accent-700 mt-1">Votre demande sera chiffrée et traitée dans un délai légal de 30 jours. Seul le responsable RGPD de NeoGTB y aura accès.</p>
                    </div>
                </div>
            </div>

            <!-- Bouton submit -->
            <button
                @click="submitForm()"
                :disabled="!form.type || !form.email || !form.name || submitted"
                class="w-full flex items-center justify-center gap-2 px-6 py-3 bg-accent-500 text-white font-medium rounded-lg hover:opacity-90 transition-opacity disabled:opacity-50 disabled:cursor-not-allowed text-[13px]">
                <template x-if="!submitted">
                    <span class="flex items-center gap-2">
                        Envoyer ma demande
                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7"/></svg>
                    </span>
                </template>
                <template x-if="submitted">
                    <span class="flex items-center gap-2">
                        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"/></svg>
                        Demande envoyée
                    </span>
                </template>
            </button>

            <!-- Confirmation -->
            <div x-show="submitted" x-transition class="mt-6 bg-accent-50 rounded-xl p-4 border border-accent-200">
                <div class="flex gap-3">
                    <svg class="w-5 h-5 text-accent-600 flex-shrink-0 mt-0.5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"/></svg>
                    <div class="text-sm leading-relaxed">
                        <p class="font-medium text-accent-800">Demande enregistrée</p>
                        <p class="text-accent-700 mt-1">Nous avons bien reçu votre demande. Vous recevrez une confirmation par email et une réponse dans un délai maximum de 30 jours.</p>
                    </div>
                </div>
            </div>

        </div>

        <!-- Lien retour -->
        <div class="text-center mt-8">
            <a href="/politique-de-confidentialite" class="text-sm text-accent-600 hover:text-accent-700 font-medium">
                &larr; Consulter notre politique de confidentialité
            </a>
        </div>

    </div>
</section>

@endsection

@push('scripts')
<script>
    document.addEventListener('alpine:init', () => {
        Alpine.data('rgpdForm', () => ({
            form: { type: '', email: '', name: '', message: '' },
            submitted: false,
            async submitForm() {
                if (!this.form.type || !this.form.email || !this.form.name) return;
                try {
                    const res = await fetch('/rgpd/request', {
                        method: 'POST',
                        body: JSON.stringify(this.form),
                        headers: {
                            'Content-Type': 'application/json',
                            'Accept': 'application/json',
                            'X-CSRF-TOKEN': document.querySelector('meta[name=csrf-token]')?.content || '',
                            'X-Requested-With': 'XMLHttpRequest',
                        },
                    });
                    if (res.ok) { this.submitted = true; }
                    else { window.location.href = 'mailto:rgpd@neogtb.fr?subject=Demande RGPD — ' + encodeURIComponent(this.form.type) + '&body=' + encodeURIComponent('Nom: ' + this.form.name + '\nEmail: ' + this.form.email + '\nType: ' + this.form.type + '\n\n' + this.form.message); }
                } catch (e) {
                    window.location.href = 'mailto:rgpd@neogtb.fr?subject=Demande RGPD — ' + encodeURIComponent(this.form.type) + '&body=' + encodeURIComponent('Nom: ' + this.form.name + '\nEmail: ' + this.form.email + '\nType: ' + this.form.type + '\n\n' + this.form.message);
                }
            },
        }));
    });
</script>
@endpush
