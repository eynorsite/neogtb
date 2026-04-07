<?php

namespace App\Services\Contact;

use App\Models\ContactMessage;

class ContactSubmissionService
{
    public function submit(array $data, string $ipHash, ?string $userAgent): ContactMessage
    {
        return ContactMessage::create(array_merge($data, [
            'ip_address' => $ipHash,
            'user_agent' => $userAgent,
            'status' => 'new',
        ]));
    }
}
