<?php

namespace App\Filament\Pages;

use App\Models\ChatbotConversation;
use App\Models\ChatbotSetting;
use Filament\Pages\Page;
use Illuminate\Support\Carbon;
use Illuminate\Support\Facades\DB;

class ChatbotStatsPage extends Page
{
    protected static string|\BackedEnum|null $navigationIcon = 'heroicon-o-chart-bar';

    protected static string|\UnitEnum|null $navigationGroup = 'Chatbot';

    protected static ?string $navigationLabel = 'Statistiques';

    protected static ?string $title = 'Statistiques du chatbot';

    protected static ?int $navigationSort = 50;

    protected string $view = 'filament.pages.chatbot-stats';

    public static function canAccess(): bool
    {
        $admin = auth()->guard('admin')->user();

        return $admin && in_array($admin->role, ['superadmin', 'admin']);
    }

    public function getStats(): array
    {
        $now = Carbon::now();
        $today = $now->copy()->startOfDay();
        $sevenDaysAgo = $now->copy()->subDays(7);
        $thirtyDaysAgo = $now->copy()->subDays(30);
        $startOfMonth = $now->copy()->startOfMonth();

        $conversationsToday = ChatbotConversation::whereDate('created_at', $today)->count();
        $conversations7d = ChatbotConversation::where('created_at', '>=', $sevenDaysAgo)->count();
        $conversations30d = ChatbotConversation::where('created_at', '>=', $thirtyDaysAgo)->count();

        $totalCostMonth = (float) ChatbotConversation::where('created_at', '>=', $startOfMonth)
            ->sum('total_cost_eur');

        $setting = ChatbotSetting::current();
        $monthlyBudget = (float) ($setting->monthly_budget_eur ?? 0);
        $budgetUsedPct = $monthlyBudget > 0
            ? min(100, round(($totalCostMonth / $monthlyBudget) * 100, 1))
            : 0.0;

        $leadsCount30d = ChatbotConversation::where('is_lead', true)
            ->where('lead_captured_at', '>=', $thirtyDaysAgo)
            ->count();

        $leadConversionRate = $conversations30d > 0
            ? round(($leadsCount30d / $conversations30d) * 100, 1)
            : 0.0;

        $avgMessagesPerConv = (float) ChatbotConversation::where('messages_count', '>', 0)
            ->avg('messages_count');
        $avgMessagesPerConv = round($avgMessagesPerConv, 1);

        $topQuestions = DB::table('chatbot_messages')
            ->select('content', DB::raw('COUNT(*) as occurrences'))
            ->where('role', 'user')
            ->groupBy('content')
            ->orderByDesc('occurrences')
            ->limit(10)
            ->get()
            ->map(fn ($row) => [
                'content' => $row->content,
                'occurrences' => (int) $row->occurrences,
            ])
            ->toArray();

        $dailyConversations = [];
        for ($i = 6; $i >= 0; $i--) {
            $day = $now->copy()->subDays($i)->startOfDay();
            $count = ChatbotConversation::whereDate('created_at', $day)->count();
            $dailyConversations[] = [
                'date' => $day->format('d/m'),
                'count' => $count,
            ];
        }

        $dailyCosts = [];
        $cumulative = 0.0;
        for ($i = 29; $i >= 0; $i--) {
            $day = $now->copy()->subDays($i)->startOfDay();
            $dayCost = (float) ChatbotConversation::whereDate('created_at', $day)->sum('total_cost_eur');
            $cumulative += $dayCost;
            $dailyCosts[] = [
                'date' => $day->format('d/m'),
                'cost' => round($dayCost, 4),
                'cumulative' => round($cumulative, 4),
            ];
        }

        return [
            'conversations_today' => $conversationsToday,
            'conversations_7d' => $conversations7d,
            'conversations_30d' => $conversations30d,
            'total_cost_month' => round($totalCostMonth, 4),
            'monthly_budget' => $monthlyBudget,
            'budget_used_pct' => $budgetUsedPct,
            'leads_count_30d' => $leadsCount30d,
            'lead_conversion_rate' => $leadConversionRate,
            'avg_messages_per_conv' => $avgMessagesPerConv,
            'top_questions' => $topQuestions,
            'daily_conversations' => $dailyConversations,
            'daily_costs' => $dailyCosts,
        ];
    }
}
