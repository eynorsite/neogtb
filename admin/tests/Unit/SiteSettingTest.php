<?php

namespace Tests\Unit;

use App\Models\SiteSetting;
use Illuminate\Foundation\Testing\RefreshDatabase;
use PHPUnit\Framework\Attributes\Test;
use Tests\TestCase;

class SiteSettingTest extends TestCase
{
    use RefreshDatabase;

    #[Test]
    public function it_can_get_and_set_values(): void
    {
        SiteSetting::create([
            'group' => 'general',
            'key' => 'site_name',
            'value' => 'NeoGTB',
            'type' => 'text',
            'label' => 'Nom du site',
        ]);

        SiteSetting::clearCache();
        $this->assertEquals('NeoGTB', SiteSetting::get('site_name'));

        SiteSetting::set('site_name', 'NeoGTB v2');
        $this->assertEquals('NeoGTB v2', SiteSetting::get('site_name'));
    }

    #[Test]
    public function it_returns_default_when_key_not_found(): void
    {
        SiteSetting::clearCache();
        $value = SiteSetting::get('inexistant', 'fallback');
        $this->assertEquals('fallback', $value);
    }
}
