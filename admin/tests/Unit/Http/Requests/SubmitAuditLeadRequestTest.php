<?php

namespace Tests\Unit\Http\Requests;

use App\Http\Requests\SubmitAuditLeadRequest;
use Illuminate\Contracts\Validation\Factory as ValidationFactory;
use PHPUnit\Framework\Attributes\Test;
use Tests\TestCase;

class SubmitAuditLeadRequestTest extends TestCase
{
    private function validate(array $data): \Illuminate\Contracts\Validation\Validator
    {
        $rules = (new SubmitAuditLeadRequest())->rules();
        return app(ValidationFactory::class)->make($data, $rules);
    }

    #[Test]
    public function test_score_max_100(): void
    {
        $v = $this->validate([
            'email' => 'lead@example.com',
            'score' => 150,
        ]);
        $this->assertTrue($v->fails());
        $this->assertArrayHasKey('score', $v->errors()->toArray());
    }

    #[Test]
    public function test_score_within_range_passes(): void
    {
        $v = $this->validate([
            'email' => 'lead@example.com',
            'score' => 75,
        ]);
        $this->assertFalse($v->fails());
    }
}
