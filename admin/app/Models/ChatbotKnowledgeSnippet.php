<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class ChatbotKnowledgeSnippet extends Model
{
    protected $table = 'chatbot_knowledge_snippets';

    protected $guarded = [];

    protected $casts = [
        'tags' => 'array',
        'is_active' => 'boolean',
        'priority' => 'integer',
    ];

    public function scopeActive($query)
    {
        return $query->where('is_active', true);
    }
}
