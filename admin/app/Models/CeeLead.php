<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class CeeLead extends Model
{
    protected $fillable = [
        'email',
        'th116_mwh',
        'th116_value',
        'sector',
        'surface',
        'climate_zone',
        'payload',
        'ip_address',
        'status',
    ];

    protected function casts(): array
    {
        return [
            'email' => 'encrypted',
            'payload' => 'array',
        ];
    }
}
