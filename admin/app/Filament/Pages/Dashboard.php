<?php

namespace App\Filament\Pages;

use App\Models\AdminActivityLog;
use App\Models\ContactMessage;
use App\Models\GdprRequest;
use App\Models\Post;
use App\Models\SitePage;
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
        return ucfirst(now()->translatedFormat('l j F Y'));
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

    public function getPublishedPosts(): int
    {
        return Post::where('status', 'published')->count();
    }

    public function getActivePages(): int
    {
        return SitePage::where('is_published', true)->count();
    }

    public function getRecentMessages(): \Illuminate\Support\Collection
    {
        return ContactMessage::latest()
            ->take(5)
            ->get(['id', 'name', 'email', 'subject', 'message', 'status', 'created_at']);
    }

    public function getRecentActivity(): \Illuminate\Support\Collection
    {
        return AdminActivityLog::with('admin')
            ->latest('created_at')
            ->take(6)
            ->get();
    }

    public function getRecentPages(): \Illuminate\Support\Collection
    {
        return SitePage::orderBy('updated_at', 'desc')
            ->take(5)
            ->get(['id', 'slug', 'name', 'is_published', 'updated_at']);
    }
}
