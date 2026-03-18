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
        'status', 'replied_at', 'reply_content', 'admin_notes',
    ];

    protected function casts(): array
    {
        return [
            'replied_at' => 'datetime',
        ];
    }
}
