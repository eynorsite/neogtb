<?php

namespace App\Services\Lead;

use App\Models\CeeLead;

class CeeLeadService
{
    public function submit(array $data, string $ipHash, ?string $userAgent = null): CeeLead
    {
        return CeeLead::create(array_merge($data, [
            'ip_address' => $ipHash,
            'user_agent' => $userAgent,
            'status' => 'new',
        ]));
    }
}
