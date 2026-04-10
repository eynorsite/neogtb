<?php

namespace App\Helpers;

use App\Models\GeneralSetting;
use Illuminate\Support\Str;

class SeoHelper
{
    public static function metaForPage(?object $page, array $defaults = []): array
    {
        return [
            'title'       => $page?->meta_title ?: GeneralSetting::value('seo_title_suffix', $defaults['title'] ?? 'NeoGTB'),
            'description' => $page?->meta_description ?: GeneralSetting::value('seo_default_description', $defaults['description'] ?? ''),
            'og_title'    => $page?->og_title ?? $page?->meta_title ?: GeneralSetting::value('seo_title_suffix', ''),
            'og_description' => $page?->og_description ?? $page?->meta_description ?: GeneralSetting::value('seo_default_description', ''),
            'og_image'    => $page?->og_image ?? GeneralSetting::value('seo_og_image'),
            'canonical'   => url()->current(),
            'robots'      => 'index, follow',
            'keywords'    => $page?->meta_keywords ?? '',
        ];
    }

    public static function metaForPost(object $post): array
    {
        return [
            'title'       => $post->meta_title ?: $post->title . ' — NeoGTB',
            'description' => $post->meta_description ?: Str::limit(strip_tags($post->excerpt ?? $post->content), 160),
            'og_title'    => $post->meta_title ?: $post->title,
            'og_description' => $post->meta_description ?: Str::limit(strip_tags($post->excerpt ?? $post->content), 160),
            'og_image'    => $post->og_image ?? $post->featured_image ?? GeneralSetting::value('seo_og_image'),
            'canonical'   => route('blog.show', $post->slug),
            'robots'      => 'index, follow',
            'keywords'    => '',
        ];
    }
}
