<?php

namespace Tests\Unit\Mail;

use App\Mail\OverdueGdprNotificationMail;
use Illuminate\Support\Collection;
use PHPUnit\Framework\Attributes\Test;
use Tests\TestCase;

class OverdueGdprNotificationMailTest extends TestCase
{
    #[Test]
    public function test_subject_contains_RGPD(): void
    {
        $mail = new OverdueGdprNotificationMail(new Collection());
        $this->assertStringContainsString('RGPD', $mail->envelope()->subject);
    }
}
