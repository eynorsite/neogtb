<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class ChatbotFaq extends Model
{
    protected $table = 'chatbot_faqs';

    protected $guarded = [];

    protected $casts = [
        'keywords' => 'array',
        'is_active' => 'boolean',
        'show_as_suggestion' => 'boolean',
        'sort_order' => 'integer',
    ];

    public function scopeActive($query)
    {
        return $query->where('is_active', true);
    }

    public function scopeSuggestions($query)
    {
        return $query->active()->where('show_as_suggestion', true)->orderBy('sort_order');
    }
}
