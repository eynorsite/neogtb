<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class ChatbotMessage extends Model
{
    protected $table = 'chatbot_messages';

    protected $guarded = [];

    protected $casts = [
        'metadata' => 'array',
        'flagged' => 'boolean',
        'tokens_in' => 'integer',
        'tokens_out' => 'integer',
        'cost_eur' => 'float',
        'latency_ms' => 'float',
    ];

    public function conversation(): BelongsTo
    {
        return $this->belongsTo(ChatbotConversation::class, 'conversation_id');
    }
}
