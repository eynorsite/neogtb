<?php

namespace App\Filament\Pages;

use App\Models\CookieConsent;
use App\Models\GdprRequest;
use App\Models\PrivacyPolicyVersion;
use Filament\Pages\Page;

class RgpdDashboardPage extends Page
{
    protected static string|\BackedEnum|null $navigationIcon = 'heroicon-o-shield-check';

    protected static string|\UnitEnum|null $navigationGroup = 'Boîte de réception';

    protected static ?string $navigationLabel = 'Suivi RGPD';

    protected static ?string $title = 'Tableau de bord RGPD';

    protected static ?int $navigationSort = 39;

    protected string $view = 'filament.pages.rgpd-dashboard';

    public static function canAccess(): bool
    {
        $admin = auth()->guard('admin')->user();

        return $admin && $admin->isAdmin();
    }

    public function getConsentsThisMonth(): int
    {
        return CookieConsent::thisMonth()->count();
    }

    public function getAcceptanceRate(): int
    {
        $total = CookieConsent::thisMonth()->count();
        if ($total === 0) return 0;

        $accepted = CookieConsent::thisMonth()
            ->whereNotNull('accepted_at')
            ->whereNull('withdrawn_at')
            ->count();

        return (int) round(($accepted / $total) * 100);
    }

    public function getPendingRequests(): int
    {
        return GdprRequest::pending()->count();
    }

    public function getOverdueRequests(): int
    {
        return GdprRequest::overdue()->count();
    }

    public function getCurrentPolicyVersion(): string
    {
        $policy = PrivacyPolicyVersion::getCurrentVersion();

        return $policy ? 'v' . $policy->version : 'Aucune';
    }

    public function getPolicyPublishedAt(): ?string
    {
        $policy = PrivacyPolicyVersion::getCurrentVersion();

        return $policy?->published_at?->format('d/m/Y');
    }

    public function getRecentRequests()
    {
        return GdprRequest::where('status', 'pending')
            ->latest()
            ->limit(5)
            ->get();
    }

    public function getExpiredConsentsCount(): int
    {
        return CookieConsent::expired()->count();
    }
}
