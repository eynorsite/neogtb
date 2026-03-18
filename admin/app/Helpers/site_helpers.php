<?php

use App\Models\SiteSetting;

if (! function_exists('site_setting')) {
    function site_setting(string $key, mixed $default = null): mixed
    {
        return SiteSetting::get($key, $default);
    }
}

if (! function_exists('site_contact')) {
    function site_contact(): object
    {
        return (object) SiteSetting::getGroup('contact');
    }
}

if (! function_exists('site_socials')) {
    function site_socials(): array
    {
        $socials = SiteSetting::getGroup('reseaux_sociaux');

        return collect($socials)
            ->filter(fn ($value, $key) => str_starts_with($key, 'social_') && str_contains($key, '_') && ! str_contains($key, 'count') && ! str_contains($key, 'score') && filled($value))
            ->mapWithKeys(fn ($value, $key) => [str_replace('social_', '', $key) => $value])
            ->toArray();
    }
}

if (! function_exists('site_seo')) {
    function site_seo(): object
    {
        return (object) SiteSetting::getGroup('seo');
    }
}

if (! function_exists('site_appearance')) {
    function site_appearance(): object
    {
        $entreprise = SiteSetting::getGroup('entreprise');
        $apparence = SiteSetting::getGroup('apparence');

        return (object) array_merge($entreprise, $apparence);
    }
}
