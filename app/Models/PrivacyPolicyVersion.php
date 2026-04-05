<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class PrivacyPolicyVersion extends Model
{
    protected $fillable = [
        'version',
        'content',
        'published_at',
        'is_current',
        'created_by',
    ];

    protected function casts(): array
    {
        return [
            'published_at' => 'datetime',
            'is_current' => 'boolean',
        ];
    }

    // --- Relations ---

    public function author(): BelongsTo
    {
        return $this->belongsTo(Admin::class, 'created_by');
    }

    // --- Scopes ---

    public function scopeCurrent($query)
    {
        return $query->where('is_current', true);
    }

    // --- Helpers ---

    public static function getCurrentVersion(): ?self
    {
        return static::where('is_current', true)->first();
    }
}
