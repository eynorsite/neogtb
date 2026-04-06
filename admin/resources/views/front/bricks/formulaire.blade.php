<section class="py-20 lg:py-28 relative overflow-hidden">
    <div class="absolute inset-0 bg-grid-pattern opacity-[0.02]"></div>
    <div class="relative z-10 mx-auto max-w-3xl px-4 sm:px-6">

        <div class="rounded-3xl bg-white border border-dark-100 shadow-xl p-8 sm:p-10 lg:p-12 animate-fade-in-up">

            @if(!empty($content['titre']))
                <div class="mb-10">
                    <h2 class="text-2xl font-heading font-extrabold text-dark-900 sm:text-3xl">{{ $content['titre'] }}</h2>
                    <div class="mt-3 h-1 w-12 rounded-full bg-gradient-to-r from-primary-500 to-accent-500"></div>
                </div>
            @endif

            @if(session('contact_success'))
                <div class="mb-10 rounded-2xl bg-gradient-to-br from-accent-50 to-accent-100 border border-accent-200 p-8 text-center animate-fade-in-up">
                    <div class="flex h-14 w-14 items-center justify-center rounded-full bg-accent-500 text-white mx-auto mb-4 shadow-lg">
                        <svg class="h-7 w-7" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"/></svg>
                    </div>
                    <p class="font-heading font-bold text-accent-700 text-lg">{{ $content['message_succes'] ?? 'Message envoye !' }}</p>
                </div>
            @endif

            <form method="POST" action="/contact/send" class="space-y-6">
                @csrf
                <input type="hidden" name="source_page" value="{{ request()->path() }}">

                <div class="grid grid-cols-1 gap-6 sm:grid-cols-2">
                    <div class="group">
                        <label class="mb-2 block text-sm font-heading font-bold text-dark-700">Nom complet <span class="text-accent-500">*</span></label>
                        <input type="text" name="name" required
                            class="w-full rounded-xl border border-dark-200 bg-dark-50/50 px-4 py-3.5 text-sm text-dark-900 transition-all duration-200 focus:border-primary-500 focus:ring-4 focus:ring-primary-100 focus:bg-white focus:outline-none placeholder:text-dark-400"
                            placeholder="Jean Dupont">
                    </div>
                    <div class="group">
                        <label class="mb-2 block text-sm font-heading font-bold text-dark-700">Email <span class="text-accent-500">*</span></label>
                        <input type="email" name="email" required
                            class="w-full rounded-xl border border-dark-200 bg-dark-50/50 px-4 py-3.5 text-sm text-dark-900 transition-all duration-200 focus:border-primary-500 focus:ring-4 focus:ring-primary-100 focus:bg-white focus:outline-none placeholder:text-dark-400"
                            placeholder="jean@entreprise.fr">
                    </div>
                </div>

                <div class="grid grid-cols-1 gap-6 sm:grid-cols-2">
                    <div class="group">
                        <label class="mb-2 block text-sm font-heading font-bold text-dark-700">Entreprise</label>
                        <input type="text" name="company"
                            class="w-full rounded-xl border border-dark-200 bg-dark-50/50 px-4 py-3.5 text-sm text-dark-900 transition-all duration-200 focus:border-primary-500 focus:ring-4 focus:ring-primary-100 focus:bg-white focus:outline-none placeholder:text-dark-400"
                            placeholder="Nom de votre entreprise">
                    </div>
                    <div class="group">
                        <label class="mb-2 block text-sm font-heading font-bold text-dark-700">Sujet <span class="text-accent-500">*</span></label>
                        <select name="subject" required
                            class="w-full rounded-xl border border-dark-200 bg-dark-50/50 px-4 py-3.5 text-sm text-dark-900 transition-all duration-200 focus:border-primary-500 focus:ring-4 focus:ring-primary-100 focus:bg-white focus:outline-none appearance-none"
                            style="background-image: url('data:image/svg+xml;utf8,<svg xmlns=%22http://www.w3.org/2000/svg%22 width=%2220%22 height=%2220%22 viewBox=%220 0 24 24%22 fill=%22none%22 stroke=%22%236b7280%22 stroke-width=%222%22><path d=%22M6 9l6 6 6-6%22/></svg>'); background-repeat: no-repeat; background-position: right 12px center; background-size: 20px;">
                            <option value="">Selectionnez un sujet</option>
                            <option value="Avis sur un devis recu">Avis sur un devis recu</option>
                            <option value="Aide au choix technologique">Aide au choix technologique</option>
                            <option value="Question reglementaire">Question reglementaire (BACS, tertiaire)</option>
                            <option value="Demande d'audit">Demande d'audit personnalise</option>
                            <option value="Partenariat">Partenariat / Collaboration</option>
                            <option value="Autre">Autre</option>
                        </select>
                    </div>
                </div>

                <div class="group">
                    <label class="mb-2 block text-sm font-heading font-bold text-dark-700">Message <span class="text-accent-500">*</span></label>
                    <textarea name="message" required rows="5"
                        class="w-full rounded-xl border border-dark-200 bg-dark-50/50 px-4 py-3.5 text-sm text-dark-900 transition-all duration-200 focus:border-primary-500 focus:ring-4 focus:ring-primary-100 focus:bg-white focus:outline-none resize-none placeholder:text-dark-400"
                        placeholder="Decrivez votre besoin..."></textarea>
                </div>

                <div class="pt-2">
                    <button type="submit"
                        class="group w-full sm:w-auto inline-flex items-center justify-center gap-2.5 rounded-xl bg-gradient-to-r from-accent-500 to-accent-600 px-10 py-4 text-base font-heading font-bold text-white shadow-lg shadow-accent-500/25 transition-all duration-300 hover:shadow-xl hover:shadow-accent-500/30 hover:-translate-y-0.5 btn-glow">
                        <svg class="h-5 w-5 transition-transform duration-300 group-hover:-translate-y-0.5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 8l7.89 5.26a2 2 0 002.22 0L21 8M5 19h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v10a2 2 0 002 2z"/></svg>
                        Envoyer le message
                    </button>
                </div>
            </form>
        </div>
    </div>
</section>
