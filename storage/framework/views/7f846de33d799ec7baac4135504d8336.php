<section class="py-16 lg:py-24">
    <div class="mx-auto max-w-3xl px-4 sm:px-6">
        <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if BLOCK]><![endif]--><?php endif; ?><?php if(!empty($content['titre'])): ?>
            <h2 class="mb-8 text-2xl font-heading font-extrabold text-dark-900"><?php echo e($content['titre']); ?></h2>
        <?php endif; ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if ENDBLOCK]><![endif]--><?php endif; ?>

        <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if BLOCK]><![endif]--><?php endif; ?><?php if(session('contact_success')): ?>
            <div class="mb-8 rounded-xl bg-accent-50 border border-accent-200 p-6 text-center">
                <span class="text-2xl">✅</span>
                <p class="mt-2 font-semibold text-accent-700"><?php echo e($content['message_succes'] ?? 'Message envoyé !'); ?></p>
            </div>
        <?php endif; ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if ENDBLOCK]><![endif]--><?php endif; ?>

        <form method="POST" action="/contact/send" class="space-y-5">
            <?php echo csrf_field(); ?>
            <input type="hidden" name="source_page" value="<?php echo e(request()->path()); ?>">

            <div class="grid grid-cols-1 gap-5 sm:grid-cols-2">
                <div>
                    <label class="mb-1.5 block text-sm font-semibold text-dark-700">Nom complet *</label>
                    <input type="text" name="name" required
                        class="w-full rounded-xl border border-dark-200 bg-white px-4 py-3 text-sm transition focus:border-primary-500 focus:ring-2 focus:ring-primary-100 focus:outline-none"
                        placeholder="Jean Dupont">
                </div>
                <div>
                    <label class="mb-1.5 block text-sm font-semibold text-dark-700">Email *</label>
                    <input type="email" name="email" required
                        class="w-full rounded-xl border border-dark-200 bg-white px-4 py-3 text-sm transition focus:border-primary-500 focus:ring-2 focus:ring-primary-100 focus:outline-none"
                        placeholder="jean@entreprise.fr">
                </div>
            </div>

            <div class="grid grid-cols-1 gap-5 sm:grid-cols-2">
                <div>
                    <label class="mb-1.5 block text-sm font-semibold text-dark-700">Entreprise</label>
                    <input type="text" name="company"
                        class="w-full rounded-xl border border-dark-200 bg-white px-4 py-3 text-sm transition focus:border-primary-500 focus:ring-2 focus:ring-primary-100 focus:outline-none"
                        placeholder="Nom de votre entreprise">
                </div>
                <div>
                    <label class="mb-1.5 block text-sm font-semibold text-dark-700">Sujet *</label>
                    <select name="subject" required
                        class="w-full rounded-xl border border-dark-200 bg-white px-4 py-3 text-sm transition focus:border-primary-500 focus:ring-2 focus:ring-primary-100 focus:outline-none">
                        <option value="">Sélectionnez un sujet</option>
                        <option value="Avis sur un devis reçu">Avis sur un devis reçu</option>
                        <option value="Aide au choix technologique">Aide au choix technologique</option>
                        <option value="Question réglementaire">Question réglementaire (BACS, tertiaire)</option>
                        <option value="Demande d'audit">Demande d'audit personnalisé</option>
                        <option value="Partenariat">Partenariat / Collaboration</option>
                        <option value="Autre">Autre</option>
                    </select>
                </div>
            </div>

            <div>
                <label class="mb-1.5 block text-sm font-semibold text-dark-700">Message *</label>
                <textarea name="message" required rows="5"
                    class="w-full rounded-xl border border-dark-200 bg-white px-4 py-3 text-sm transition focus:border-primary-500 focus:ring-2 focus:ring-primary-100 focus:outline-none"
                    placeholder="Décrivez votre besoin..."></textarea>
            </div>

            <button type="submit"
                class="w-full sm:w-auto inline-flex items-center justify-center gap-2 rounded-xl bg-accent-500 px-8 py-3.5 text-base font-bold text-dark-900 shadow-lg transition hover:bg-accent-600 btn-glow">
                ✉️ Envoyer le message
            </button>
        </form>
    </div>
</section>
<?php /**PATH /var/www/neogtb/admin/resources/views/front/bricks/formulaire.blade.php ENDPATH**/ ?>