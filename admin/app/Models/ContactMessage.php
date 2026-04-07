<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class ContactMessage extends Model
{
    use SoftDeletes;

    protected $fillable = [
        'name', 'email', 'phone', 'company', 'subject', 'message',
        'source_page', 'ip_address', 'user_agent',
    ];

    protected $attributes = [
        'status' => 'new',
    ];

    protected function casts(): array
    {
        return [
            'replied_at' => 'datetime',
            'name' => 'encrypted',
            'email' => 'encrypted',
            'phone' => 'encrypted',
            'company' => 'encrypted',
            'message' => 'encrypted',
            'user_agent' => 'encrypted',
        ];
    }
}
