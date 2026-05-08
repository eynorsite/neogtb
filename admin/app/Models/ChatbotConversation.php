<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

class ChatbotConversation extends Model
{
    protected $table = 'chatbot_conversations';

    protected $guarded = [];

    protected $casts = [
        'consent_given' => 'boolean',
        'is_lead' => 'boolean',
        'consent_given_at' => 'datetime',
        'lead_captured_at' => 'datetime',
        'last_activity_at' => 'datetime',
        'total_cost_eur' => 'float',
        'messages_count' => 'integer',
        'total_tokens_in' => 'integer',
        'total_tokens_out' => 'integer',
    ];

    public function messages(): HasMany
    {
        return $this->hasMany(ChatbotMessage::class, 'conversation_id')->orderBy('created_at');
    }

    public function markAsLead(?string $email = null, ?string $name = null, ?string $note = null): void
    {
        $this->update([
            'is_lead' => true,
            'lead_email' => $email,
            'lead_name' => $name,
            'lead_note' => $note,
            'lead_captured_at' => now(),
        ]);
    }
}
