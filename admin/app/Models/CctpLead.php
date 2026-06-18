<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class CctpLead extends Model
{
    protected $fillable = [
        'email',
        'company',
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
