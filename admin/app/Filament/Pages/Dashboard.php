<?php

namespace App\Filament\Pages;

use App\Models\ContactMessage;
use App\Models\GdprRequest;
use Filament\Pages\Dashboard as BaseDashboard;
class Dashboard extends BaseDashboard
{
    protected static ?string $navigationLabel = 'Tableau de bord';

    protected static ?string $title = '';

    public function getView(): string
    {
        return 'filament.pages.dashboard';
    }

    public function getGreeting(): string
    {
        $hour = now()->hour;

        if ($hour < 12) {
            return 'Bonjour';
        }

        return $hour < 18 ? 'Bon après-midi' : 'Bonsoir';
    }

    public function getAdminName(): string
    {
        return auth()->guard('admin')->user()->name;
    }

    public function getFormattedDate(): string
    {
        return now()->translatedFormat('l j F Y');
    }

    public function getUnreadMessages(): int
    {
        return ContactMessage::where('status', 'new')->count();
    }

    public function getPendingGdpr(): int
    {
        return GdprRequest::where('status', 'pending')->count();
    }

    public function getOverdueGdpr(): int
    {
        return GdprRequest::where('status', 'pending')
            ->where('created_at', '<', now()->subDays(30))
            ->count();
    }
}
