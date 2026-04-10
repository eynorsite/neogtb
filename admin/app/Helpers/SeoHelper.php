<?php

namespace App\Helpers;

use App\Models\SiteSetting;
use Illuminate\Support\Str;

class SeoHelper
{
    public static function metaForPage(?object $page, array $defaults = []): array
    {
        return [
            'title'       => $page?->meta_title ?: SiteSetting::get('seo_meta_title_defaut', $defaults['title'] ?? 'NeoGTB'),
            'description' => $page?->meta_description ?: SiteSetting::get('seo_meta_description_defaut', $defaults['description'] ?? ''),
            'og_title'    => $page?->og_title ?? $page?->meta_title ?: SiteSetting::get('seo_meta_title_defaut', ''),
            'og_description' => $page?->og_description ?? $page?->meta_description ?: SiteSetting::get('seo_meta_description_defaut', ''),
            'og_image'    => $page?->og_image ?? SiteSetting::get('seo_og_image_defaut'),
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
            'og_image'    => $post->og_image ?? $post->featured_image ?? SiteSetting::get('seo_og_image_defaut'),
            'canonical'   => route('blog.show', $post->slug),
            'robots'      => 'index, follow',
            'keywords'    => '',
        ];
    }
}
