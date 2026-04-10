<?php

use App\Models\GeneralSetting;

if (! function_exists('site_setting')) {
    function site_setting(string $key, mixed $default = null): mixed
    {
        return GeneralSetting::value($key, $default);
    }
}

if (! function_exists('site_contact')) {
    function site_contact(): object
    {
        $s = GeneralSetting::get();

        return (object) [
            'company_email'       => $s->company_email,
            'company_phone'       => $s->company_phone,
            'company_address'     => $s->company_address,
            'company_city'        => $s->company_city,
            'company_postal_code' => $s->company_postal_code,
            'full_address'        => $s->full_address,
        ];
    }
}

if (! function_exists('site_socials')) {
    function site_socials(): array
    {
        return GeneralSetting::get()->social_links;
    }
}

if (! function_exists('site_seo')) {
    function site_seo(): object
    {
        $s = GeneralSetting::get();

        return (object) [
            'seo_title_suffix'        => $s->seo_title_suffix,
            'seo_default_description' => $s->seo_default_description,
            'seo_og_image'            => $s->seo_og_image,
        ];
    }
}

if (! function_exists('site_appearance')) {
    function site_appearance(): object
    {
        $s = GeneralSetting::get();

        return (object) [
            'company_name'    => $s->company_name,
            'primary_color'   => $s->primary_color,
            'secondary_color' => $s->secondary_color,
            'accent_color'    => $s->accent_color,
            'company_logo'    => $s->company_logo,
            'font_pair'       => $s->font_pair,
        ];
    }
}
