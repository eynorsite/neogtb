<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Casts\Attribute;

class GdprRequest extends Model
{
    protected $fillable = [
        'type',
        'email',
        'name',
        'message',
        'status',
        'processed_by',
        'processed_at',
        'response_content',
        'response_sent_at',
        'admin_notes',
    ];

    protected function casts(): array
    {
        return [
            'email' => 'encrypted',
            'name' => 'encrypted',
            'message' => 'encrypted',
            'response_content' => 'encrypted',
            'admin_notes' => 'encrypted',
            'processed_at' => 'datetime',
            'response_sent_at' => 'datetime',
        ];
    }

    // --- Relations ---

    public function processor(): BelongsTo
    {
        return $this->belongsTo(Admin::class, 'processed_by');
    }

    // --- Scopes ---

    public function scopePending($query)
    {
        return $query->where('status', 'pending');
    }

    public function scopeOverdue($query)
    {
        // Demandes pendantes de plus de 30 jours (délai légal RGPD)
        return $query->where('status', 'pending')
            ->where('created_at', '<', now()->subDays(30));
    }

    public function scopeArchivable($query)
    {
        // Demandes traitées depuis plus de 3 ans
        return $query->where('status', 'completed')
            ->where('processed_at', '<', now()->subYears(3));
    }

    // --- Helpers ---

    public function isOverdue(): bool
    {
        return $this->status === 'pending'
            && $this->created_at->diffInDays(now()) > 30;
    }

    public function getTypeLabel(): string
    {
        return match ($this->type) {
            'access' => 'Droit d\'accès',
            'deletion' => 'Droit à l\'effacement',
            'portability' => 'Droit à la portabilité',
            'rectification' => 'Droit de rectification',
            'opposition' => 'Droit d\'opposition',
            default => $this->type,
        };
    }

    public function getStatusLabel(): string
    {
        return match ($this->status) {
            'pending' => 'En attente',
            'processing' => 'En cours',
            'completed' => 'Traitée',
            'rejected' => 'Rejetée',
            default => $this->status,
        };
    }

    public function getMaskedEmail(): string
    {
        $email = $this->email;
        if (!$email) return '***';

        $parts = explode('@', $email);
        if (count($parts) !== 2) return '***';

        $local = $parts[0];
        $masked = substr($local, 0, 1) . str_repeat('*', max(strlen($local) - 2, 1)) . substr($local, -1);

        return $masked . '@' . $parts[1];
    }
}
