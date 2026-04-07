<?php

namespace Tests\Unit\Http\Requests;

use App\Http\Requests\SubmitGdprRequest;
use Illuminate\Contracts\Validation\Factory as ValidationFactory;
use PHPUnit\Framework\Attributes\Test;
use Tests\TestCase;

class SubmitGdprRequestTest extends TestCase
{
    private function validate(array $data): \Illuminate\Contracts\Validation\Validator
    {
        $rules = (new SubmitGdprRequest())->rules();
        return app(ValidationFactory::class)->make($data, $rules);
    }

    #[Test]
    public function test_type_must_be_in_enum(): void
    {
        $v = $this->validate([
            'type' => 'access',
            'email' => 'a@b.com',
            'name' => 'Jane',
        ]);
        $this->assertFalse($v->fails());
    }

    #[Test]
    public function test_invalid_type_rejected(): void
    {
        $v = $this->validate([
            'type' => 'pirate',
            'email' => 'a@b.com',
            'name' => 'Jane',
        ]);
        $this->assertTrue($v->fails());
        $this->assertArrayHasKey('type', $v->errors()->toArray());
    }
}
