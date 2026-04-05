<x-filament-panels::page>

    @php
        $unread = $this->getUnreadMessages();
        $pendingGdpr = $this->getPendingGdpr();
        $overdueGdpr = $this->getOverdueGdpr();
        $posts = $this->getPublishedPosts();
        $pages = $this->getActivePages();
        $messages = $this->getRecentMessages();
        $activity = $this->getRecentActivity();
        $recentPages = $this->getRecentPages();
    @endphp

    {{-- GREETING --}}
    <div class="dash-header">
        <h1 class="dash-greeting">
            {{ $this->getGreeting() }}, <span class="gradient-name">{{ $this->getAdminName() }}</span> 👋
        </h1>
        <p class="dash-date">{{ $this->getFormattedDate() }} — Voici un résumé de votre activité</p>
    </div>

    {{-- KPI CARDS --}}
    <div class="kpi-grid">
        <div class="kpi-card kpi-visitors">
            <div class="kpi-top">
                <div class="kpi-icon">
                    <x-heroicon-o-eye class="w-6 h-6" />
                </div>
                <div class="kpi-trend neutral">—</div>
            </div>
            <div class="kpi-value">{{ $pages }}</div>
            <div class="kpi-label">Pages actives</div>
        </div>

        <div class="kpi-card kpi-messages">
            <div class="kpi-top">
                <div class="kpi-icon">
                    <x-heroicon-o-envelope class="w-6 h-6" />
                </div>
                @if($unread > 0)
                    <div class="kpi-trend down">! {{ $unread }}</div>
                @else
                    <div class="kpi-trend up">✓</div>
                @endif
            </div>
            <div class="kpi-value">{{ $unread }}</div>
            <div class="kpi-label">Messages non lus</div>
        </div>

        <div class="kpi-card kpi-posts">
            <div class="kpi-top">
                <div class="kpi-icon">
                    <x-heroicon-o-newspaper class="w-6 h-6" />
                </div>
                <div class="kpi-trend up">{{ $posts }}</div>
            </div>
            <div class="kpi-value">{{ $posts }}</div>
            <div class="kpi-label">Articles publiés</div>
        </div>

        <div class="kpi-card kpi-gdpr">
            <div class="kpi-top">
                <div class="kpi-icon">
                    <x-heroicon-o-shield-check class="w-6 h-6" />
                </div>
                @if($overdueGdpr > 0)
                    <div class="kpi-trend down">! {{ $overdueGdpr }}</div>
                @elseif($pendingGdpr > 0)
                    <div class="kpi-trend neutral">{{ $pendingGdpr }}</div>
                @else
                    <div class="kpi-trend up">✓ OK</div>
                @endif
            </div>
            <div class="kpi-value">{{ $pendingGdpr }}</div>
            <div class="kpi-label">Demandes RGPD en attente</div>
        </div>
    </div>

    {{-- QUICK ACTIONS --}}
    <div class="section-header">
        <h2 class="section-title">Actions rapides</h2>
    </div>
    <div class="quick-actions">
        <a href="{{ \App\Filament\Resources\PostResource::getUrl('create') }}" class="quick-action">
            <div class="quick-action-icon">
                <x-heroicon-o-pencil-square class="w-5 h-5" />
            </div>
            <div>
                <p class="quick-action-title">Nouvel article</p>
                <p class="quick-action-desc">Rédiger et publier un post</p>
            </div>
        </a>
        <a href="{{ url('/admin/pages') }}" class="quick-action">
            <div class="quick-action-icon">
                <x-heroicon-o-document-text class="w-5 h-5" />
            </div>
            <div>
                <p class="quick-action-title">Modifier une page</p>
                <p class="quick-action-desc">Éditer le contenu du site</p>
            </div>
        </a>
        <a href="{{ \App\Filament\Resources\ContactMessageResource::getUrl() }}" class="quick-action">
            <div class="quick-action-icon">
                <x-heroicon-o-chat-bubble-left-right class="w-5 h-5" />
            </div>
            <div>
                <p class="quick-action-title">Voir les messages</p>
                <p class="quick-action-desc">{{ $unread }} message{{ $unread > 1 ? 's' : '' }} non lu{{ $unread > 1 ? 's' : '' }}</p>
            </div>
        </a>
        <a href="https://neogtb.fr" target="_blank" class="quick-action">
            <div class="quick-action-icon">
                <x-heroicon-o-globe-alt class="w-5 h-5" />
            </div>
            <div>
                <p class="quick-action-title">Voir le site</p>
                <p class="quick-action-desc">neogtb.fr</p>
            </div>
        </a>
    </div>

    {{-- CONTENT GRID: Messages + Activity --}}
    <div class="content-grid">
        {{-- RECENT MESSAGES --}}
        <div class="dash-card">
            <div class="dash-card-header">
                <span class="dash-card-title">Derniers messages</span>
                <a href="{{ \App\Filament\Resources\ContactMessageResource::getUrl() }}" class="dash-card-link">
                    Tout voir →
                </a>
            </div>
            <div class="dash-card-body">
                @forelse($messages as $msg)
                    @php
                        $initials = collect(explode(' ', $msg->name))->map(fn($w) => mb_strtoupper(mb_substr($w, 0, 1)))->take(2)->join('');
                        $colors = ['linear-gradient(135deg, #6C3AED, #8B5CF6)', 'linear-gradient(135deg, #06B6D4, #22D3EE)', 'linear-gradient(135deg, #F59E0B, #FBBF24)', 'linear-gradient(135deg, #10B981, #34D399)', 'linear-gradient(135deg, #EF4444, #F87171)'];
                        $color = $colors[$loop->index % count($colors)];
                    @endphp
                    <div class="message-item">
                        <div class="msg-status {{ $msg->status !== 'new' ? 'read' : '' }}"></div>
                        <div class="msg-avatar" style="background: {{ $color }}">{{ $initials }}</div>
                        <div class="msg-content">
                            <div class="msg-name">{{ $msg->name }}</div>
                            <div class="msg-preview">{{ Str::limit($msg->subject ?: $msg->message, 60) }}</div>
                        </div>
                        <div class="msg-time">{{ $msg->created_at->diffForHumans(short: true) }}</div>
                    </div>
                @empty
                    <div style="text-align: center; padding: 2rem; color: var(--neo-text-muted);">
                        <x-heroicon-o-envelope class="w-8 h-8 mx-auto mb-2" style="opacity: 0.3;" />
                        <p style="font-size: 0.875rem;">Aucun message</p>
                    </div>
                @endforelse
            </div>
        </div>

        {{-- RECENT ACTIVITY --}}
        <div class="dash-card">
            <div class="dash-card-header">
                <span class="dash-card-title">Activité récente</span>
            </div>
            <div class="dash-card-body">
                @forelse($activity as $log)
                    @php
                        $iconClass = match($log->action) {
                            'created' => 'create',
                            'updated' => 'edit',
                            'deleted' => 'delete',
                            default => 'login',
                        };
                        $modelName = $log->model_type ? class_basename($log->model_type) : '';
                        $actionLabel = match($log->action) {
                            'created' => 'a créé',
                            'updated' => 'a modifié',
                            'deleted' => 'a supprimé',
                            default => $log->action,
                        };
                    @endphp
                    <div class="activity-item">
                        <div class="activity-icon {{ $iconClass }}">
                            @switch($iconClass)
                                @case('create')
                                    <x-heroicon-o-check class="w-4 h-4" />
                                    @break
                                @case('edit')
                                    <x-heroicon-o-pencil class="w-4 h-4" />
                                    @break
                                @case('delete')
                                    <x-heroicon-o-trash class="w-4 h-4" />
                                    @break
                                @default
                                    <x-heroicon-o-arrow-right-on-rectangle class="w-4 h-4" />
                            @endswitch
                        </div>
                        <div class="activity-text">
                            <div class="activity-desc">
                                <strong>{{ $log->admin?->name ?? 'Système' }}</strong>
                                {{ $actionLabel }}
                                @if($modelName) un{{ in_array($modelName, ['SitePage', 'PostCategory']) ? 'e' : '' }} {{ $modelName }} @endif
                            </div>
                            <div class="activity-time">{{ $log->created_at->diffForHumans() }}</div>
                        </div>
                    </div>
                @empty
                    <div style="text-align: center; padding: 2rem; color: var(--neo-text-muted);">
                        <p style="font-size: 0.875rem;">Aucune activité récente</p>
                    </div>
                @endforelse
            </div>
        </div>
    </div>

    {{-- BOTTOM GRID: Pages --}}
    <div class="bottom-grid">
        <div class="dash-card">
            <div class="dash-card-header">
                <span class="dash-card-title">Pages du site</span>
                <a href="{{ url('/admin/pages') }}" class="dash-card-link">Gérer →</a>
            </div>
            <div class="dash-card-body" style="padding: 1rem 1.5rem;">
                <table class="pages-table">
                    <thead>
                        <tr>
                            <th>Page</th>
                            <th>Statut</th>
                            <th>Modifiée</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach($recentPages as $page)
                            <tr>
                                <td><span class="page-name">{{ $page->name }}</span></td>
                                <td>
                                    <span class="status-badge {{ $page->is_published ? 'published' : 'draft' }}">
                                        <span class="status-dot"></span>
                                        {{ $page->is_published ? 'Publiée' : 'Brouillon' }}
                                    </span>
                                </td>
                                <td style="color: var(--neo-text-muted); font-size: 0.75rem;">
                                    {{ $page->updated_at->diffForHumans(short: true) }}
                                </td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
        </div>

        {{-- Stats summary --}}
        <div class="dash-card">
            <div class="dash-card-header">
                <span class="dash-card-title">Résumé du site</span>
                <a href="https://neogtb.fr" target="_blank" class="dash-card-link">Voir →</a>
            </div>
            <div class="dash-card-body">
                <div style="display: grid; grid-template-columns: 1fr 1fr; gap: 1rem;">
                    <div style="text-align: center; padding: 1.25rem; background: #F5F3FF; border-radius: var(--neo-radius-lg);">
                        <div style="font-size: 2rem; font-weight: 800; color: #6C3AED;">{{ $pages }}</div>
                        <div style="font-size: 0.75rem; color: var(--neo-text-secondary); margin-top: 0.25rem;">Pages actives</div>
                    </div>
                    <div style="text-align: center; padding: 1.25rem; background: #F0FDF4; border-radius: var(--neo-radius-lg);">
                        <div style="font-size: 2rem; font-weight: 800; color: #10B981;">{{ $posts }}</div>
                        <div style="font-size: 0.75rem; color: var(--neo-text-secondary); margin-top: 0.25rem;">Articles blog</div>
                    </div>
                    <div style="text-align: center; padding: 1.25rem; background: #ECFEFF; border-radius: var(--neo-radius-lg);">
                        <div style="font-size: 2rem; font-weight: 800; color: #06B6D4;">{{ \App\Models\ContactMessage::count() }}</div>
                        <div style="font-size: 0.75rem; color: var(--neo-text-secondary); margin-top: 0.25rem;">Messages total</div>
                    </div>
                    <div style="text-align: center; padding: 1.25rem; background: #FEF2F2; border-radius: var(--neo-radius-lg);">
                        <div style="font-size: 2rem; font-weight: 800; color: #EF4444;">{{ $pendingGdpr }}</div>
                        <div style="font-size: 0.75rem; color: var(--neo-text-secondary); margin-top: 0.25rem;">RGPD en attente</div>
                    </div>
                </div>
            </div>
        </div>
    </div>

</x-filament-panels::page>
