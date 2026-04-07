<?php

namespace App\Filament\Bricks\Structure;

use App\Filament\Bricks\BaseBrick;

class BrickWizardPlaceholder extends BaseBrick
{
    public function type(): string { return 'wizard-placeholder'; }
    public function name(): string { return 'Wizard Placeholder'; }
    public function icon(): string { return '🧩'; }
    public function description(): string { return 'Marqueur pour injection de wizard Alpine custom'; }
    public function category(): string { return 'Structure'; }

    public function defaultContent(): array
    {
        return [];
    }

    public function defaultSettings(): array
    {
        return [];
    }

    public function schema(): array
    {
        return [];
    }

    public function preview(array $content): string
    {
        return '<div class="text-xs text-gray-400">— wizard placeholder —</div>';
    }
}
