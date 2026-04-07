<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class NewsletterSubscriber extends Model
{
    use HasFactory;

    protected $fillable = [
        'email', 'confirmation_token', 'is_confirmed',
        'confirmed_at', 'unsubscribed_at', 'ip_hash',
    ];

    protected function casts(): array
    {
        return [
            'email' => 'encrypted',
            'is_confirmed' => 'boolean',
            'confirmed_at' => 'datetime',
            'unsubscribed_at' => 'datetime',
        ];
    }
}
