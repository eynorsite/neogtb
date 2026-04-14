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
        <p class="dash-date">{{ $this->getFormattedDate() }} — Voici un resume de votre activite</p>
    </div>

    {{-- KPI CARDS with sparklines --}}
    <div class="kpi-grid">
        <div class="kpi-card kpi-visitors">
            <div class="kpi-top">
                <div class="kpi-icon"><x-heroicon-o-document-text class="w-6 h-6" /></div>
                <div class="kpi-trend up">{{ $pages }} actives</div>
            </div>
            <div class="kpi-value">{{ $pages }}</div>
            <div class="kpi-label">Pages du site</div>
            <div class="kpi-sparkline">
                <svg viewBox="0 0 200 40" preserveAspectRatio="none">
                    <defs><linearGradient id="sp1" x1="0%" y1="0%" x2="0%" y2="100%"><stop offset="0%" style="stop-color:#6C3AED;stop-opacity:0.3"/><stop offset="100%" style="stop-color:#6C3AED;stop-opacity:0"/></linearGradient></defs>
                    <path d="M0,35 L25,30 L50,32 L75,25 L100,20 L125,15 L150,12 L175,8 L200,5" fill="none" stroke="#6C3AED" stroke-width="2.5" stroke-linecap="round"/>
                    <path d="M0,35 L25,30 L50,32 L75,25 L100,20 L125,15 L150,12 L175,8 L200,5 L200,40 L0,40Z" fill="url(#sp1)"/>
                </svg>
            </div>
        </div>

        <div class="kpi-card kpi-messages">
            <div class="kpi-top">
                <div class="kpi-icon"><x-heroicon-o-envelope class="w-6 h-6" /></div>
                @if($unread > 0)
                    <div class="kpi-trend down">! {{ $unread }} non lu{{ $unread > 1 ? 's' : '' }}</div>
                @else
                    <div class="kpi-trend up">Tout lu</div>
                @endif
            </div>
            <div class="kpi-value">{{ $unread }}</div>
            <div class="kpi-label">Messages non lus</div>
            <div class="kpi-sparkline">
                <svg viewBox="0 0 200 40" preserveAspectRatio="none">
                    <defs><linearGradient id="sp2" x1="0%" y1="0%" x2="0%" y2="100%"><stop offset="0%" style="stop-color:#06B6D4;stop-opacity:0.3"/><stop offset="100%" style="stop-color:#06B6D4;stop-opacity:0"/></linearGradient></defs>
                    <path d="M0,20 L25,25 L50,18 L75,22 L100,28 L125,15 L150,20 L175,22 L200,20" fill="none" stroke="#06B6D4" stroke-width="2.5" stroke-linecap="round"/>
                    <path d="M0,20 L25,25 L50,18 L75,22 L100,28 L125,15 L150,20 L175,22 L200,20 L200,40 L0,40Z" fill="url(#sp2)"/>
                </svg>
            </div>
        </div>

        <div class="kpi-card kpi-posts">
            <div class="kpi-top">
                <div class="kpi-icon"><x-heroicon-o-newspaper class="w-6 h-6" /></div>
                <div class="kpi-trend up">{{ $posts }} publies</div>
            </div>
            <div class="kpi-value">{{ $posts }}</div>
            <div class="kpi-label">Articles blog</div>
            <div class="kpi-sparkline">
                <svg viewBox="0 0 200 40" preserveAspectRatio="none">
                    <defs><linearGradient id="sp3" x1="0%" y1="0%" x2="0%" y2="100%"><stop offset="0%" style="stop-color:#10B981;stop-opacity:0.3"/><stop offset="100%" style="stop-color:#10B981;stop-opacity:0"/></linearGradient></defs>
                    <path d="M0,38 L25,36 L50,34 L75,30 L100,24 L125,20 L150,16 L175,10 L200,5" fill="none" stroke="#10B981" stroke-width="2.5" stroke-linecap="round"/>
                    <path d="M0,38 L25,36 L50,34 L75,30 L100,24 L125,20 L150,16 L175,10 L200,5 L200,40 L0,40Z" fill="url(#sp3)"/>
                </svg>
            </div>
        </div>

        <div class="kpi-card kpi-gdpr">
            <div class="kpi-top">
                <div class="kpi-icon"><x-heroicon-o-shield-check class="w-6 h-6" /></div>
                @if($overdueGdpr > 0)
                    <div class="kpi-trend down">! {{ $overdueGdpr }} en retard</div>
                @elseif($pendingGdpr > 0)
                    <div class="kpi-trend neutral">{{ $pendingGdpr }} en attente</div>
                @else
                    <div class="kpi-trend up">OK</div>
                @endif
            </div>
            <div class="kpi-value">{{ $pendingGdpr }}</div>
            <div class="kpi-label">Demandes RGPD</div>
            <div class="kpi-sparkline">
                <svg viewBox="0 0 200 40" preserveAspectRatio="none">
                    <defs><linearGradient id="sp4" x1="0%" y1="0%" x2="0%" y2="100%"><stop offset="0%" style="stop-color:#EF4444;stop-opacity:0.3"/><stop offset="100%" style="stop-color:#EF4444;stop-opacity:0"/></linearGradient></defs>
                    <path d="M0,30 L25,28 L50,32 L75,25 L100,30 L125,22 L150,28 L175,30 L200,32" fill="none" stroke="#EF4444" stroke-width="2.5" stroke-linecap="round"/>
                    <path d="M0,30 L25,28 L50,32 L75,25 L100,30 L125,22 L150,28 L175,30 L200,32 L200,40 L0,40Z" fill="url(#sp4)"/>
                </svg>
            </div>
        </div>
    </div>

    {{-- QUICK ACTIONS --}}
    @php
        $settingsUrl = fn ($tabId = null) => \App\Filament\Pages\SiteSettingsPage::getUrl() . ($tabId ? '?tab=' . urlencode($tabId) : '');
        $newLeads = $this->getNewLeads();
    @endphp
    <div class="section-header">
        <h2 class="section-title">Que voulez-vous faire ?</h2>
        <p class="section-subtitle">Raccourcis vers les réglages les plus fréquents</p>
    </div>
    <div class="quick-actions">
        <a href="{{ \App\Filament\Resources\ContactMessageResource::getUrl() }}" class="quick-action" data-color="amber">
            <div class="quick-action-icon" aria-hidden="true"><x-heroicon-o-chat-bubble-left-right class="w-5 h-5" /></div>
            <div>
                <p class="quick-action-title">Messages reçus</p>
                <p class="quick-action-desc">
                    @if($unread > 0)
                        {{ $unread }} message{{ $unread > 1 ? 's' : '' }} non lu{{ $unread > 1 ? 's' : '' }}
                    @else
                        Formulaire de contact
                    @endif
                </p>
            </div>
        </a>
        <a href="{{ \App\Filament\Resources\AuditLeadResource::getUrl() }}" class="quick-action" data-color="teal">
            <div class="quick-action-icon" aria-hidden="true"><x-heroicon-o-chart-bar class="w-5 h-5" /></div>
            <div>
                <p class="quick-action-title">Demandes d'audit</p>
                <p class="quick-action-desc">
                    @if($newLeads > 0)
                        {{ $newLeads }} demande{{ $newLeads > 1 ? 's' : '' }} non traitée{{ $newLeads > 1 ? 's' : '' }} (audit + CEE)
                    @else
                        Diagnostics GTB et CEE
                    @endif
                </p>
            </div>
        </a>
        <a href="{{ \App\Filament\Resources\PostResource::getUrl('create') }}" class="quick-action" data-color="green">
            <div class="quick-action-icon" aria-hidden="true"><x-heroicon-o-newspaper class="w-5 h-5" /></div>
            <div>
                <p class="quick-action-title">Nouvel article</p>
                <p class="quick-action-desc">Rédiger et publier un article</p>
            </div>
        </a>
        <a href="{{ url('/admin/pages') }}" class="quick-action" data-color="cyan">
            <div class="quick-action-icon" aria-hidden="true"><x-heroicon-o-document-text class="w-5 h-5" /></div>
            <div>
                <p class="quick-action-title">Pages du site</p>
                <p class="quick-action-desc">GTB, GTC, Solutions, À propos, FAQ…</p>
            </div>
        </a>
        <a href="{{ url('/admin/homepage') }}" class="quick-action" data-color="blue">
            <div class="quick-action-icon" aria-hidden="true"><x-heroicon-o-home class="w-5 h-5" /></div>
            <div>
                <p class="quick-action-title">Page d'accueil</p>
                <p class="quick-action-desc">Sections hero, chiffres, CTA, témoignages</p>
            </div>
        </a>
        <a href="{{ $settingsUrl('textes-du-site') }}" class="quick-action" data-color="violet">
            <div class="quick-action-icon" aria-hidden="true"><x-heroicon-o-pencil-square class="w-5 h-5" /></div>
            <div>
                <p class="quick-action-title">Éditer un texte</p>
                <p class="quick-action-desc">Boutons, formulaires, footer, menus…</p>
            </div>
        </a>
        <a href="{{ $settingsUrl('identite-visuelle') }}" class="quick-action" data-color="pink">
            <div class="quick-action-icon" aria-hidden="true"><x-heroicon-o-swatch class="w-5 h-5" /></div>
            <div>
                <p class="quick-action-title">Logo et couleurs</p>
                <p class="quick-action-desc">Identité visuelle, favicon, image de partage</p>
            </div>
        </a>
        <a href="{{ $settingsUrl('seo') }}" class="quick-action" data-color="indigo">
            <div class="quick-action-icon" aria-hidden="true"><x-heroicon-o-magnifying-glass class="w-5 h-5" /></div>
            <div>
                <p class="quick-action-title">SEO et référencement</p>
                <p class="quick-action-desc">Meta description, title, Schema.org, Google</p>
            </div>
        </a>
        <a href="{{ $settingsUrl('mentions-rgpd') }}" class="quick-action" data-color="slate">
            <div class="quick-action-icon" aria-hidden="true"><x-heroicon-o-scale class="w-5 h-5" /></div>
            <div>
                <p class="quick-action-title">Mentions légales et RGPD</p>
                <p class="quick-action-desc">Confidentialité, cookies, CGU</p>
            </div>
        </a>
    </div>

    {{-- CONTENT GRID --}}
    <div class="content-grid">
        <div class="dash-card">
            <div class="dash-card-header">
                <span class="dash-card-title">Derniers messages</span>
                <a href="{{ \App\Filament\Resources\ContactMessageResource::getUrl() }}" class="dash-card-link">Tout voir →</a>
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
                            <div class="msg-preview">{{ Str::limit($msg->subject ?: $msg->message, 55) }}</div>
                        </div>
                        <div class="msg-time">{{ $msg->created_at->diffForHumans(short: true) }}</div>
                    </div>
                @empty
                    <div class="dash-empty">
                        <x-heroicon-o-envelope class="w-8 h-8" />
                        <p>Aucun message pour le moment</p>
                    </div>
                @endforelse
            </div>
        </div>

        <div class="dash-card">
            <div class="dash-card-header">
                <span class="dash-card-title">Activite recente</span>
            </div>
            <div class="dash-card-body">
                @forelse($activity as $log)
                    @php
                        $iconClass = match($log->action) { 'created' => 'create', 'updated' => 'edit', 'deleted' => 'delete', default => 'login' };
                        $actionLabel = match($log->action) { 'created' => 'a cree', 'updated' => 'a modifie', 'deleted' => 'a supprime', default => $log->action };
                        $modelName = $log->model_type ? class_basename($log->model_type) : '';
                    @endphp
                    <div class="activity-item">
                        <div class="activity-icon {{ $iconClass }}">
                            @switch($iconClass)
                                @case('create') <x-heroicon-o-check class="w-4 h-4" /> @break
                                @case('edit') <x-heroicon-o-pencil class="w-4 h-4" /> @break
                                @case('delete') <x-heroicon-o-trash class="w-4 h-4" /> @break
                                @default <x-heroicon-o-arrow-right-on-rectangle class="w-4 h-4" />
                            @endswitch
                        </div>
                        <div class="activity-text">
                            <div class="activity-desc">
                                <strong>{{ $log->admin?->name ?? 'Systeme' }}</strong>
                                {{ $actionLabel }}
                                @if($modelName) un{{ in_array($modelName, ['SitePage', 'PostCategory']) ? 'e' : '' }} {{ $modelName }} @endif
                            </div>
                            <div class="activity-time">{{ $log->created_at->diffForHumans() }}</div>
                        </div>
                    </div>
                @empty
                    <div class="dash-empty">
                        <x-heroicon-o-clock class="w-8 h-8" />
                        <p>Aucune activite recente</p>
                    </div>
                @endforelse
            </div>
        </div>
    </div>

    {{-- BOTTOM GRID --}}
    <div class="bottom-grid">
        <div class="dash-card">
            <div class="dash-card-header">
                <span class="dash-card-title">Pages du site</span>
                <a href="{{ url('/admin/pages') }}" class="dash-card-link">Gerer →</a>
            </div>
            <div class="dash-card-body" style="padding: 0.75rem 1.5rem;">
                <table class="pages-table">
                    <thead><tr><th>Page</th><th>Statut</th><th>Modifiee</th></tr></thead>
                    <tbody>
                        @foreach($recentPages as $page)
                            <tr>
                                <td><span class="page-name">{{ $page->name }}</span></td>
                                <td>
                                    <span class="status-badge {{ $page->is_published ? 'published' : 'draft' }}">
                                        <span class="status-dot"></span>
                                        {{ $page->is_published ? 'Publiee' : 'Brouillon' }}
                                    </span>
                                </td>
                                <td style="color: var(--neo-text-muted); font-size: 0.6875rem;">{{ $page->updated_at->diffForHumans(short: true) }}</td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
        </div>

        <div class="dash-card">
            <div class="dash-card-header">
                <span class="dash-card-title">Resume du site</span>
                <a href="https://neogtb.fr" target="_blank" class="dash-card-link">Voir →</a>
            </div>
            <div class="dash-card-body">
                <div style="display: grid; grid-template-columns: 1fr 1fr; gap: 0.75rem;">
                    <div class="stat-block" style="background: #F5F3FF;">
                        <div class="stat-block-value" style="color: #6C3AED;">{{ $pages }}</div>
                        <div class="stat-block-label">Pages actives</div>
                    </div>
                    <div class="stat-block" style="background: #F0FDF4;">
                        <div class="stat-block-value" style="color: #10B981;">{{ $posts }}</div>
                        <div class="stat-block-label">Articles blog</div>
                    </div>
                    <div class="stat-block" style="background: #ECFEFF;">
                        <div class="stat-block-value" style="color: #06B6D4;">{{ $this->getTotalMessages() }}</div>
                        <div class="stat-block-label">Messages total</div>
                    </div>
                    <div class="stat-block" style="background: #FEF2F2;">
                        <div class="stat-block-value" style="color: #EF4444;">{{ $pendingGdpr }}</div>
                        <div class="stat-block-label">RGPD en attente</div>
                    </div>
                </div>
            </div>
        </div>
    </div>

</x-filament-panels::page>
