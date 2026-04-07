<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class AuditLead extends Model
{
    protected $fillable = [
        'email',
        'name',
        'company',
        'score',
        'level_label',
        'building_type',
        'surface',
        'savings_euro',
        'payload',
        'ip_address',
        'status',
    ];

    protected function casts(): array
    {
        return [
            'email' => 'encrypted',
            'name' => 'encrypted',
            'company' => 'encrypted',
            'payload' => 'array',
        ];
    }
}
