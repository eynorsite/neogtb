<section class="py-16 lg:py-24" style="background-color: <?php echo e($settings['couleur_fond'] ?? '#ffffff'); ?>">
    <div class="mx-auto max-w-7xl px-4 sm:px-6 lg:px-8">
        <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if BLOCK]><![endif]--><?php endif; ?><?php if(!empty($content['titre'])): ?>
            <h2 class="mb-8 text-3xl font-bold text-gray-900 sm:text-4xl"><?php echo e($content['titre']); ?></h2>
        <?php endif; ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if ENDBLOCK]><![endif]--><?php endif; ?>

        <?php $pos = $settings['position_image'] ?? 'none'; ?>

        <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if BLOCK]><![endif]--><?php endif; ?><?php if($pos !== 'none' && !empty($content['image'])): ?>
            <div class="flex flex-col gap-12 <?php echo e($pos === 'right' ? 'lg:flex-row' : 'lg:flex-row-reverse'); ?>">
                <div class="flex-1 prose prose-lg max-w-none text-gray-600">
                    <?php echo $content['contenu'] ?? ''; ?>

                </div>
                <div class="flex-1">
                    <img src="<?php echo e(asset('storage/' . $content['image'])); ?>" alt="" class="rounded-2xl shadow-lg">
                </div>
            </div>
        <?php else: ?>
            <div class="prose prose-lg mx-auto max-w-4xl text-gray-600">
                <?php echo $content['contenu'] ?? ''; ?>

            </div>
        <?php endif; ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if ENDBLOCK]><![endif]--><?php endif; ?>
    </div>
</section>
<?php /**PATH /var/www/neogtb/admin/resources/views/front/bricks/texte.blade.php ENDPATH**/ ?>