<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class PageSection extends Model
{
    protected $fillable = [
        'page_id', 'section_key', 'title', 'subtitle',
        'content', 'image', 'extra_data', 'order', 'is_visible',
    ];

    protected function casts(): array
    {
        return [
            'extra_data' => 'array',
            'is_visible' => 'boolean',
        ];
    }

    public function page(): BelongsTo
    {
        return $this->belongsTo(SitePage::class, 'page_id');
    }
}
