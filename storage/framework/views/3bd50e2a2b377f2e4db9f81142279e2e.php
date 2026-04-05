<?php
    $hauteur = match($settings['hauteur'] ?? 'medium') {
        'full' => 'min-h-screen',
        'medium' => 'min-h-[70vh]',
        'compact' => 'min-h-[45vh]',
        default => 'min-h-[70vh]',
    };
    $align = match($settings['alignement'] ?? 'center') {
        'left' => 'text-left items-start',
        'right' => 'text-right items-end',
        default => 'text-center items-center',
    };
?>

<section class="<?php echo e($hauteur); ?> relative flex items-center justify-center overflow-hidden bg-gradient-to-br from-dark-950 via-primary-900 to-dark-900">
    <div class="absolute top-20 left-10 w-72 h-72 bg-accent-500/20 rounded-full blur-3xl animate-float"></div>
    <div class="absolute bottom-20 right-10 w-96 h-96 bg-primary-500/20 rounded-full blur-3xl animate-float" style="animation-delay: -2s;"></div>
    <div class="absolute top-1/2 left-1/2 -translate-x-1/2 -translate-y-1/2 w-[500px] h-[500px] bg-primary-600/10 rounded-full blur-3xl"></div>
    <div class="absolute inset-0 bg-grid-pattern opacity-[0.03]"></div>

    <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if BLOCK]><![endif]--><?php endif; ?><?php if(!empty($content['image'])): ?>
        <div class="absolute inset-0">
            <img src="<?php echo e(asset('storage/' . $content['image'])); ?>" alt="" class="h-full w-full object-cover opacity-20">
        </div>
    <?php endif; ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if ENDBLOCK]><![endif]--><?php endif; ?>

    <div class="relative z-10 mx-auto max-w-4xl px-4 py-24 <?php echo e($align); ?>">
        <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if BLOCK]><![endif]--><?php endif; ?><?php if(!empty($content['badge'])): ?>
            <div class="mb-6 inline-flex items-center gap-2 rounded-full bg-accent-500/20 border border-accent-500/30 px-4 py-1.5 text-sm font-medium text-accent-300 backdrop-blur-sm animate-fade-in-up">
                <?php echo e($content['badge']); ?>

            </div>
        <?php endif; ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if ENDBLOCK]><![endif]--><?php endif; ?>

        <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if BLOCK]><![endif]--><?php endif; ?><?php if(!empty($content['titre'])): ?>
            <h1 class="text-4xl font-heading font-extrabold leading-tight text-white sm:text-5xl lg:text-6xl animate-fade-in-up" style="animation-delay: 0.1s;">
                <?php echo preg_replace('/\b(GTB|GTC|NeoGTB)\b/', '<span class="text-gradient">$1</span>', e($content['titre'])); ?>

            </h1>
        <?php endif; ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if ENDBLOCK]><![endif]--><?php endif; ?>

        <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if BLOCK]><![endif]--><?php endif; ?><?php if(!empty($content['sous_titre'])): ?>
            <p class="mt-6 text-lg text-dark-300 sm:text-xl animate-fade-in-up" style="animation-delay: 0.2s;">
                <?php echo e($content['sous_titre']); ?>

            </p>
        <?php endif; ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if ENDBLOCK]><![endif]--><?php endif; ?>

        <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if BLOCK]><![endif]--><?php endif; ?><?php if(!empty($content['description'])): ?>
            <p class="mx-auto mt-4 max-w-2xl text-base leading-relaxed text-dark-400 animate-fade-in-up" style="animation-delay: 0.3s;">
                <?php echo e($content['description']); ?>

            </p>
        <?php endif; ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if ENDBLOCK]><![endif]--><?php endif; ?>

        <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if BLOCK]><![endif]--><?php endif; ?><?php if(!empty($content['cta_texte']) || !empty($content['cta2_texte'])): ?>
            <div class="mt-10 flex flex-wrap gap-4 <?php echo e(($settings['alignement'] ?? 'center') === 'center' ? 'justify-center' : ''); ?> animate-fade-in-up" style="animation-delay: 0.4s;">
                <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if BLOCK]><![endif]--><?php endif; ?><?php if(!empty($content['cta_texte'])): ?>
                    <a href="<?php echo e($content['cta_lien'] ?? '#'); ?>"
                       class="inline-flex items-center gap-2 rounded-xl bg-accent-500 px-8 py-4 text-base font-bold text-dark-900 shadow-lg transition hover:bg-accent-600 btn-glow">
                        <?php echo e($content['cta_texte']); ?>

                        <svg class="h-5 w-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 8l4 4m0 0l-4 4m4-4H3"/></svg>
                    </a>
                <?php endif; ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if ENDBLOCK]><![endif]--><?php endif; ?>
                <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if BLOCK]><![endif]--><?php endif; ?><?php if(!empty($content['cta2_texte'])): ?>
                    <a href="<?php echo e($content['cta2_lien'] ?? '#'); ?>"
                       class="inline-flex items-center gap-2 rounded-xl border-2 border-white/20 bg-white/10 px-8 py-4 text-base font-bold text-white shadow-lg backdrop-blur-sm transition hover:bg-white/20">
                        <?php echo e($content['cta2_texte']); ?>

                        <svg class="h-5 w-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 8l4 4m0 0l-4 4m4-4H3"/></svg>
                    </a>
                <?php endif; ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if ENDBLOCK]><![endif]--><?php endif; ?>
            </div>
        <?php endif; ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if ENDBLOCK]><![endif]--><?php endif; ?>
    </div>
</section>
<?php /**PATH /var/www/neogtb/admin/resources/views/front/bricks/hero.blade.php ENDPATH**/ ?>