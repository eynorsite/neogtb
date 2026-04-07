<?php

namespace App\Services\Gdpr;

use App\Models\GdprRequest;

class GdprRequestService
{
    public function submit(array $data): GdprRequest
    {
        return GdprRequest::create(array_merge($data, ['status' => 'pending']));
    }
}
