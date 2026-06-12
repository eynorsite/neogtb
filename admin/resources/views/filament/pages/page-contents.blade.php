<x-filament-panels::page>
    <form wire:submit="save">
        {{ $this->form }}

        <div class="mt-6 flex flex-wrap items-center justify-end gap-3">
            <x-filament::button
                type="button"
                color="gray"
                icon="heroicon-o-arrow-down-tray"
                wire:click="downloadBackup">
                Télécharger une sauvegarde
            </x-filament::button>

            @if ($this->hasRevisions())
                <x-filament::button
                    type="button"
                    color="warning"
                    icon="heroicon-o-arrow-uturn-left"
                    wire:click="undoLastChange"
                    wire:confirm="Annuler votre dernière modification ? Le contenu reviendra à son état d'avant le dernier enregistrement.">
                    Annuler ma dernière modification
                </x-filament::button>
            @endif

            <x-filament::button type="submit" icon="heroicon-o-check">
                Enregistrer le contenu
            </x-filament::button>
        </div>
    </form>
</x-filament-panels::page>
