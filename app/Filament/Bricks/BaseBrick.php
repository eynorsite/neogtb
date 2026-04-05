<?php

namespace App\Filament\Bricks;

abstract class BaseBrick
{
    abstract public function type(): string;

    abstract public function name(): string;

    abstract public function icon(): string;

    abstract public function description(): string;

    abstract public function category(): string;

    abstract public function defaultContent(): array;

    abstract public function schema(): array;

    public function defaultSettings(): array
    {
        return [];
    }

    public function preview(array $content): string
    {
        return '<div class="text-sm text-gray-500">' . $this->name() . '</div>';
    }

    public function validate(array $content): bool
    {
        return true;
    }

    public static function make(): static
    {
        return new static();
    }
}
