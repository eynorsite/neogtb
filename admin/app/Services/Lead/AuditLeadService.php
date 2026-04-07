<?php

namespace App\Services\Lead;

use App\Models\AuditLead;

class AuditLeadService
{
    public function submit(array $data, string $ipHash, ?string $userAgent = null): AuditLead
    {
        return AuditLead::create(array_merge($data, [
            'ip_address' => $ipHash,
            'user_agent' => $userAgent,
            'status' => 'new',
        ]));
    }
}
