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
            'consentement_rgpd' => true,
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
            'consentement_rgpd' => true,
            'score' => 75,
        ]);
        $this->assertFalse($v->fails());
    }

    #[Test]
    public function test_building_type_is_validated_and_accepted(): void
    {
        $v = $this->validate([
            'email' => 'lead@example.com',
            'consentement_rgpd' => true,
            'building_type' => 'bureau',
            'surface' => 1200,
            'score' => 62,
            'level_label' => 'Niveau B',
            'savings_euro' => 5400,
            'payload' => ['form' => ['x' => 1]],
        ]);
        $this->assertFalse($v->fails(), 'Les champs diagnostic (building_type, surface, score, level_label, savings_euro, payload) doivent etre valides.');
    }

    #[Test]
    public function test_honeypot_blocks_bot_submission(): void
    {
        $v = $this->validate([
            'email' => 'bot@example.com',
            'consentement_rgpd' => true,
            '_gotcha' => 'spammed',
        ]);
        $this->assertTrue($v->fails());
        $this->assertArrayHasKey('_gotcha', $v->errors()->toArray());
    }
}
