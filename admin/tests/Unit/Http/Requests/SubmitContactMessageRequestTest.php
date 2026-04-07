<?php

namespace Tests\Unit\Http\Requests;

use App\Http\Requests\SubmitContactMessageRequest;
use Illuminate\Contracts\Validation\Factory as ValidationFactory;
use PHPUnit\Framework\Attributes\Test;
use Tests\TestCase;

class SubmitContactMessageRequestTest extends TestCase
{
    private function validate(array $data): \Illuminate\Contracts\Validation\Validator
    {
        $rules = (new SubmitContactMessageRequest())->rules();
        return app(ValidationFactory::class)->make($data, $rules);
    }

    private function validData(array $overrides = []): array
    {
        return array_merge([
            'name' => 'Jean Dupont',
            'email' => 'jean@example.com',
            'subject' => 'Bonjour',
            'message' => 'Ceci est un message de test suffisamment long.',
        ], $overrides);
    }

    #[Test]
    public function test_email_required(): void
    {
        $v = $this->validate($this->validData(['email' => null]));
        $this->assertTrue($v->fails());
        $this->assertArrayHasKey('email', $v->errors()->toArray());
    }

    #[Test]
    public function test_message_max_5000(): void
    {
        $v = $this->validate($this->validData(['message' => str_repeat('a', 5001)]));
        $this->assertTrue($v->fails());
        $this->assertArrayHasKey('message', $v->errors()->toArray());
    }

    #[Test]
    public function test_not_regex_blocks_newlines_in_name(): void
    {
        $v = $this->validate($this->validData(['name' => "Jean\nDupont"]));
        $this->assertTrue($v->fails());
        $this->assertArrayHasKey('name', $v->errors()->toArray());
    }

    #[Test]
    public function test_valid_data_passes(): void
    {
        $v = $this->validate($this->validData());
        $this->assertFalse($v->fails());
    }
}
