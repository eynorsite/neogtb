<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class CookieConsent extends Model
{
    protected $fillable = [
        'visitor_id',
        'ip_hash',
        'consents',
        'version',
        'user_agent_hash',
        'accepted_at',
        'refused_at',
        'withdrawn_at',
    ];

    protected function casts(): array
    {
        return [
            'consents' => 'array',
            'accepted_at' => 'datetime',
            'refused_at' => 'datetime',
            'withdrawn_at' => 'datetime',
        ];
    }

    public function hasAccepted(): bool
    {
        return $this->accepted_at !== null && $this->withdrawn_at === null;
    }

    public function hasRefused(): bool
    {
        return $this->refused_at !== null;
    }

    public function scopeActive($query)
    {
        return $query->whereNull('withdrawn_at');
    }

    public function scopeThisMonth($query)
    {
        return $query->where('created_at', '>=', now()->startOfMonth());
    }

    public function scopeExpired($query)
    {
        // Consentements de plus de 13 mois (conformité RGPD)
        return $query->where('created_at', '<', now()->subMonths(13));
    }
}
