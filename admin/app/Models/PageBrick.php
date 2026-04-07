<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class PageBrick extends Model
{
    protected $fillable = [
        'page_id',
        'brick_type',
        'brick_name',
        'content',
        'settings',
        'order',
        'is_visible',
        'created_by',
        'updated_by',
    ];

    protected $casts = [
        'content' => 'array',
        'settings' => 'array',
        'is_visible' => 'boolean',
        'is_locked' => 'boolean',
    ];

    public function page(): BelongsTo
    {
        return $this->belongsTo(SitePage::class, 'page_id');
    }

    public function creator(): BelongsTo
    {
        return $this->belongsTo(Admin::class, 'created_by');
    }

    public function updater(): BelongsTo
    {
        return $this->belongsTo(Admin::class, 'updated_by');
    }

    public function getContentValue(string $key, mixed $default = null): mixed
    {
        return data_get($this->content, $key, $default);
    }

    public function setContentValue(string $key, mixed $value): void
    {
        $content = $this->content ?? [];
        data_set($content, $key, $value);
        $this->content = $content;
    }
}
