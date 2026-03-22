<x-filament-panels::page>
    <form wire:submit="save" class="space-y-6">

        {{-- Image hero --}}
        <div class="fi-section rounded-xl bg-white shadow-sm ring-1 ring-gray-950/5 dark:bg-gray-900 dark:ring-white/10 p-6">
            <h3 class="text-base font-semibold text-gray-950 dark:text-white mb-4">Image du hero</h3>

            @if($current_image)
                <div class="mb-4">
                    <p class="text-sm text-gray-500 mb-2">Image actuelle :</p>
                    <img src="{{ $current_image }}" alt="Hero actuel" class="rounded-lg max-h-48 object-cover border border-gray-200 dark:border-gray-700">
                </div>
            @endif

            <div>
                <label class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-1">Nouvelle image (remplace l'actuelle)</label>
                <input type="file" wire:model="hero_image" accept="image/*" class="block w-full text-sm text-gray-500 file:mr-4 file:py-2 file:px-4 file:rounded-lg file:border-0 file:text-sm file:font-semibold file:bg-primary-50 file:text-primary-700 hover:file:bg-primary-100 dark:file:bg-primary-900/20 dark:file:text-primary-400">
                @error('hero_image') <span class="text-sm text-danger-600">{{ $message }}</span> @enderror
            </div>

            <div class="mt-3">
                <label class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-1">Texte alternatif de l'image</label>
                <input type="text" wire:model="image_alt" class="fi-input block w-full rounded-lg border-gray-300 shadow-sm focus:border-primary-500 focus:ring-primary-500 dark:border-gray-700 dark:bg-gray-800 dark:text-white sm:text-sm" placeholder="Description de l'image pour l'accessibilité">
            </div>
        </div>

        {{-- Textes hero --}}
        <div class="fi-section rounded-xl bg-white shadow-sm ring-1 ring-gray-950/5 dark:bg-gray-900 dark:ring-white/10 p-6">
            <h3 class="text-base font-semibold text-gray-950 dark:text-white mb-4">Contenu du hero</h3>

            <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                <div>
                    <label class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-1">Badge</label>
                    <input type="text" wire:model="badge" class="fi-input block w-full rounded-lg border-gray-300 shadow-sm focus:border-primary-500 focus:ring-primary-500 dark:border-gray-700 dark:bg-gray-800 dark:text-white sm:text-sm" placeholder="Indépendant · Objectif · Solutions">
                </div>

                <div>
                    <label class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-1">Sous-titre</label>
                    <input type="text" wire:model="subtitle" class="fi-input block w-full rounded-lg border-gray-300 shadow-sm focus:border-primary-500 focus:ring-primary-500 dark:border-gray-700 dark:bg-gray-800 dark:text-white sm:text-sm" placeholder="NéoGTB">
                </div>
            </div>

            <div class="mt-4">
                <label class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-1">Titre principal (H1)</label>
                <input type="text" wire:model="title_text" class="fi-input block w-full rounded-lg border-gray-300 shadow-sm focus:border-primary-500 focus:ring-primary-500 dark:border-gray-700 dark:bg-gray-800 dark:text-white sm:text-sm" placeholder="Le tiers de confiance de la GTB en France">
            </div>

            <div class="mt-4">
                <label class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-1">Description</label>
                <textarea wire:model="description" rows="3" class="fi-input block w-full rounded-lg border-gray-300 shadow-sm focus:border-primary-500 focus:ring-primary-500 dark:border-gray-700 dark:bg-gray-800 dark:text-white sm:text-sm" placeholder="NeoGTB ne vend rien..."></textarea>
            </div>
        </div>

        {{-- CTAs --}}
        <div class="fi-section rounded-xl bg-white shadow-sm ring-1 ring-gray-950/5 dark:bg-gray-900 dark:ring-white/10 p-6">
            <h3 class="text-base font-semibold text-gray-950 dark:text-white mb-4">Boutons d'action</h3>

            <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                <div>
                    <label class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-1">Texte CTA principal</label>
                    <input type="text" wire:model="cta_text" class="fi-input block w-full rounded-lg border-gray-300 shadow-sm focus:border-primary-500 focus:ring-primary-500 dark:border-gray-700 dark:bg-gray-800 dark:text-white sm:text-sm" placeholder="Diagnostiquer mon bâtiment">
                </div>
                <div>
                    <label class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-1">Lien CTA principal</label>
                    <input type="text" wire:model="cta_url" class="fi-input block w-full rounded-lg border-gray-300 shadow-sm focus:border-primary-500 focus:ring-primary-500 dark:border-gray-700 dark:bg-gray-800 dark:text-white sm:text-sm" placeholder="/audit">
                </div>
            </div>

            <div class="grid grid-cols-1 md:grid-cols-2 gap-4 mt-4">
                <div>
                    <label class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-1">Texte CTA secondaire</label>
                    <input type="text" wire:model="cta2_text" class="fi-input block w-full rounded-lg border-gray-300 shadow-sm focus:border-primary-500 focus:ring-primary-500 dark:border-gray-700 dark:bg-gray-800 dark:text-white sm:text-sm" placeholder="Notre méthode">
                </div>
                <div>
                    <label class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-1">Lien CTA secondaire</label>
                    <input type="text" wire:model="cta2_url" class="fi-input block w-full rounded-lg border-gray-300 shadow-sm focus:border-primary-500 focus:ring-primary-500 dark:border-gray-700 dark:bg-gray-800 dark:text-white sm:text-sm" placeholder="/about">
                </div>
            </div>
        </div>

        <div class="flex justify-end">
            <button type="submit" class="fi-btn fi-btn-size-md relative grid-flow-col items-center justify-center font-semibold outline-none transition duration-75 focus-visible:ring-2 rounded-lg fi-color-custom fi-btn-color-primary fi-color-primary fi-size-md gap-1.5 px-3 py-2 text-sm inline-grid shadow-sm bg-primary-600 text-white hover:bg-primary-500 focus-visible:ring-primary-500/50 dark:bg-primary-500 dark:hover:bg-primary-400 dark:focus-visible:ring-primary-400/50">
                Enregistrer les modifications
            </button>
        </div>
    </form>
</x-filament-panels::page>
