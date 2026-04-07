<?php

namespace Tests\Unit\Models;

use App\Models\Admin;
use App\Models\AuditLead;
use App\Models\ContactMessage;
use App\Models\GdprRequest;
use App\Models\NewsletterSubscriber;
use Database\Factories\AuditLeadFactory;
use Database\Factories\ContactMessageFactory;
use Database\Factories\GdprRequestFactory;
use Database\Factories\NewsletterSubscriberFactory;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Support\Facades\DB;
use PHPUnit\Framework\Attributes\Test;
use Tests\TestCase;

class EncryptionTest extends TestCase
{
    use RefreshDatabase;

    #[Test]
    public function test_contact_message_encrypts_email_in_database(): void
    {
        $plain = 'plain-encrypt@example.com';
        ContactMessageFactory::new()->create(['email' => $plain]);

        $row = DB::table('contact_messages')->first();
        $this->assertNotEquals($plain, $row->email);
        $this->assertNotNull($row->email);
    }

    #[Test]
    public function test_contact_message_decrypts_email_via_eloquent(): void
    {
        $plain = 'decrypt-me@example.com';
        ContactMessageFactory::new()->create(['email' => $plain]);

        $msg = ContactMessage::first();
        $this->assertEquals($plain, $msg->email);
    }

    #[Test]
    public function test_gdpr_request_encrypts_message(): void
    {
        $plain = 'mon message rgpd top secret';
        GdprRequestFactory::new()->create(['message' => $plain]);

        $row = DB::table('gdpr_requests')->first();
        $this->assertNotEquals($plain, $row->message);
        $this->assertEquals($plain, GdprRequest::first()->message);
    }

    #[Test]
    public function test_audit_lead_encrypts_email(): void
    {
        $plain = 'audit-lead@example.com';
        AuditLeadFactory::new()->create(['email' => $plain]);

        $row = DB::table('audit_leads')->first();
        $this->assertNotEquals($plain, $row->email);
        $this->assertEquals($plain, AuditLead::first()->email);
    }

    #[Test]
    public function test_newsletter_subscriber_encrypts_email(): void
    {
        $plain = 'newsletter@example.com';
        NewsletterSubscriberFactory::new()->create(['email' => $plain]);

        $row = DB::table('newsletter_subscribers')->first();
        $this->assertNotEquals($plain, $row->email);
        $this->assertEquals($plain, NewsletterSubscriber::first()->email);
    }

    #[Test]
    public function test_admin_encrypts_last_login_ip(): void
    {
        $ip = '203.0.113.42';
        $admin = Admin::factory()->create(['last_login_ip' => $ip]);

        $row = DB::table('admins')->where('id', $admin->id)->first();
        $this->assertNotEquals($ip, $row->last_login_ip);
        $this->assertEquals($ip, Admin::find($admin->id)->last_login_ip);
    }
}
