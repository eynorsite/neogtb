<?php

namespace Tests\Unit;

use App\Models\ContactMessage;
use Illuminate\Foundation\Testing\RefreshDatabase;
use PHPUnit\Framework\Attributes\Test;
use Tests\TestCase;

class ContactMessageTest extends TestCase
{
    use RefreshDatabase;

    #[Test]
    public function it_creates_with_status_new(): void
    {
        $message = ContactMessage::create([
            'name' => 'Jean Dupont',
            'email' => 'jean@example.com',
            'subject' => 'Demande info GTB',
            'message' => 'Bonjour, je souhaite des informations.',
            'status' => 'new',
        ]);

        $this->assertEquals('new', $message->status);
        $this->assertNull($message->replied_at);
    }

    #[Test]
    public function it_soft_deletes_messages(): void
    {
        $message = ContactMessage::create([
            'name' => 'Test Soft Delete',
            'email' => 'test@example.com',
            'subject' => 'Test',
            'message' => 'Test message',
            'status' => 'new',
        ]);

        $message->delete();

        $this->assertSoftDeleted($message);
        $this->assertEquals(0, ContactMessage::count());
        $this->assertEquals(1, ContactMessage::withTrashed()->count());
    }
}
