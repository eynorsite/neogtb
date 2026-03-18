<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\SoftDeletes;

class SitePage extends Model
{
    use SoftDeletes;

    protected $table = 'site_pages';

    protected $fillable = [
        'slug', 'name', 'hero_title', 'hero_subtitle', 'hero_description',
        'hero_cta_text', 'hero_cta_url', 'hero_image',
        'meta_title', 'meta_description', 'meta_keywords',
        'og_title', 'og_description', 'og_image',
        'is_published', 'order',
    ];

    protected function casts(): array
    {
        return [
            'is_published' => 'boolean',
        ];
    }

    public function sections(): HasMany
    {
        return $this->hasMany(PageSection::class, 'page_id')->orderBy('order');
    }
}
