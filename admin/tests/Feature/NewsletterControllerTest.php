<?php

namespace Tests\Feature;

use App\Models\NewsletterSubscriber;
use Database\Factories\NewsletterSubscriberFactory;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Str;
use PHPUnit\Framework\Attributes\Test;
use Tests\TestCase;

class NewsletterControllerTest extends TestCase
{
    use RefreshDatabase;

    #[Test]
    public function test_subscribe_creates_unconfirmed_subscriber(): void
    {
        Mail::fake();

        $response = $this->postJson('/newsletter', ['email' => 'test@example.com']);
        $response->assertOk();

        $sub = NewsletterSubscriber::first();
        $this->assertNotNull($sub);
        $this->assertFalse($sub->is_confirmed);
        $this->assertEquals('test@example.com', $sub->email);
    }

    #[Test]
    public function test_subscribe_validates_email(): void
    {
        $response = $this->postJson('/newsletter', ['email' => 'not-an-email']);
        $response->assertStatus(422);
    }

    #[Test]
    public function test_confirm_marks_subscriber_confirmed(): void
    {
        $token = Str::random(64);
        $sub = NewsletterSubscriberFactory::new()->create([
            'confirmation_token' => $token,
            'is_confirmed' => false,
        ]);

        $response = $this->get('/newsletter/confirm/' . $token);
        $response->assertOk();

        $this->assertTrue($sub->fresh()->is_confirmed);
    }

    #[Test]
    public function test_unsubscribe_sets_unsubscribed_at(): void
    {
        NewsletterSubscriberFactory::new()->create(['email' => 'bye@example.com']);

        $response = $this->postJson('/newsletter/unsubscribe', ['email' => 'bye@example.com']);
        $response->assertOk();

        $this->assertNotNull(NewsletterSubscriber::first()->unsubscribed_at);
    }
}
