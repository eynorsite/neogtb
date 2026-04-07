<?php

namespace Tests\Unit\Mail;

use App\Mail\NewsletterConfirmationMail;
use Database\Factories\NewsletterSubscriberFactory;
use Illuminate\Foundation\Testing\RefreshDatabase;
use PHPUnit\Framework\Attributes\Test;
use Tests\TestCase;

class NewsletterConfirmationMailTest extends TestCase
{
    use RefreshDatabase;

    #[Test]
    public function test_subject_contains_NeoGTB(): void
    {
        $sub = NewsletterSubscriberFactory::new()->create();
        $mail = new NewsletterConfirmationMail($sub);
        $this->assertStringContainsString('NeoGTB', $mail->envelope()->subject);
    }

    #[Test]
    public function test_uses_view_emails_newsletter_confirmation(): void
    {
        $sub = NewsletterSubscriberFactory::new()->create();
        $mail = new NewsletterConfirmationMail($sub);
        $this->assertEquals('emails.newsletter-confirmation', $mail->content()->view);
    }
}
