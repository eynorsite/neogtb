<style>
    /* ============================================
       NEOGTB ADMIN — PREMIUM DESIGN SYSTEM
       v2.0 — Expert audit implementation
       ============================================ */

    :root {
        --neo-primary: #6C3AED;
        --neo-primary-light: #8B5CF6;
        --neo-primary-dark: #5B21B6;
        --neo-primary-glow: rgba(108,58,237,0.15);
        --neo-bg: #F5F3FF;
        --neo-card: #FFFFFF;
        --neo-text: #1e1b4b;
        --neo-text-secondary: #6b7280;
        --neo-text-muted: #9ca3af;
        --neo-border: #e5e7eb;
        --neo-border-light: #f3f4f6;
        --neo-sidebar-bg: #1e1b4b;
        --neo-sidebar-text: #c4b5fd;
        --neo-radius: 12px;
        --neo-radius-lg: 16px;
        --neo-radius-xl: 20px;
        --neo-shadow-xs: 0 1px 2px rgba(0,0,0,0.04);
        --neo-shadow: 0 4px 12px rgba(0,0,0,0.05), 0 1px 3px rgba(0,0,0,0.04);
        --neo-shadow-lg: 0 12px 40px rgba(0,0,0,0.08);
        --neo-shadow-glow: 0 0 30px var(--neo-primary-glow);
        --neo-transition: all 0.2s cubic-bezier(0.4, 0, 0.2, 1);
    }

    /* ============================================
       GLOBAL — Body, fonts, scrollbar
       ============================================ */
    .fi-body {
        background-color: var(--neo-bg) !important;
        -webkit-font-smoothing: antialiased;
        -moz-osx-font-smoothing: grayscale;
    }

    ::-webkit-scrollbar { width: 6px; height: 6px; }
    ::-webkit-scrollbar-track { background: transparent; }
    ::-webkit-scrollbar-thumb { background: #d1d5db; border-radius: 3px; }
    ::-webkit-scrollbar-thumb:hover { background: #9ca3af; }

    /* ============================================
       SIDEBAR — Dark indigo, gradient active
       ============================================ */
    .fi-sidebar {
        background: linear-gradient(180deg, var(--neo-sidebar-bg) 0%, #15133a 100%) !important;
        border-right: none !important;
    }

    .fi-sidebar .fi-sidebar-header {
        border-bottom-color: rgba(255,255,255,0.06) !important;
        padding: 20px 16px !important;
    }

    .fi-sidebar .fi-sidebar-header a,
    .fi-sidebar .fi-sidebar-header span,
    .fi-sidebar-header .fi-logo span,
    .fi-sidebar-header a span {
        color: #ffffff !important;
        font-weight: 700 !important;
    }

    .fi-sidebar .fi-sidebar-group-label,
    .fi-sidebar .fi-sidebar-nav .fi-sidebar-group > button > span {
        color: rgba(255,255,255,0.35) !important;
        font-size: 0.65rem !important;
        text-transform: uppercase !important;
        letter-spacing: 1.2px !important;
        font-weight: 700 !important;
        padding-top: 1.25rem !important;
    }

    .fi-sidebar .fi-sidebar-item a,
    .fi-sidebar .fi-sidebar-item button {
        color: var(--neo-sidebar-text) !important;
        border-radius: 10px !important;
        transition: var(--neo-transition) !important;
        font-size: 0.8125rem !important;
        font-weight: 500 !important;
        padding: 0.5rem 0.75rem !important;
    }

    .fi-sidebar .fi-sidebar-item a:hover,
    .fi-sidebar .fi-sidebar-item button:hover {
        background-color: rgba(139,92,246,0.12) !important;
        color: #ffffff !important;
    }

    .fi-sidebar .fi-sidebar-item.fi-active a,
    .fi-sidebar .fi-sidebar-item.fi-active button,
    .fi-sidebar .fi-sidebar-item a[aria-current="page"] {
        background: linear-gradient(135deg, var(--neo-primary), var(--neo-primary-light)) !important;
        color: #ffffff !important;
        font-weight: 600 !important;
        border-left: none !important;
        box-shadow: 0 4px 15px rgba(108,58,237,0.4) !important;
    }

    .fi-sidebar .fi-sidebar-item svg {
        color: inherit !important;
        opacity: 0.7;
        width: 18px !important;
        height: 18px !important;
    }

    .fi-sidebar .fi-sidebar-item.fi-active svg,
    .fi-sidebar .fi-sidebar-item a[aria-current="page"] svg {
        opacity: 1;
        color: #ffffff !important;
    }

    .fi-sidebar .fi-icon-btn { color: var(--neo-sidebar-text) !important; }
    .fi-sidebar .fi-sidebar-group > button svg { color: rgba(255,255,255,0.3) !important; }

    .fi-sidebar .fi-sidebar-footer,
    .fi-sidebar nav + div {
        border-top-color: rgba(255,255,255,0.06) !important;
    }

    /* Sidebar badge (notifications) */
    .fi-sidebar .fi-badge {
        background: #EF4444 !important;
        color: white !important;
        font-size: 0.6rem !important;
        min-width: 18px !important;
        padding: 1px 6px !important;
        border-radius: 10px !important;
        font-weight: 700 !important;
    }

    /* ============================================
       TOPBAR — Clean, subtle shadow
       ============================================ */
    .fi-topbar {
        background-color: var(--neo-card) !important;
        border-bottom: 1px solid var(--neo-border) !important;
        box-shadow: var(--neo-shadow-xs) !important;
    }

    .fi-topbar nav { padding: 0 0.5rem !important; }

    /* ============================================
       CARDS & SECTIONS — Premium radius + shadow
       ============================================ */
    .fi-section {
        border-radius: var(--neo-radius-lg) !important;
        box-shadow: var(--neo-shadow) !important;
        border: 1px solid var(--neo-border-light) !important;
        overflow: hidden;
        transition: var(--neo-transition);
    }

    .fi-section:hover {
        box-shadow: var(--neo-shadow), 0 0 0 1px rgba(108,58,237,0.04) !important;
    }

    .fi-section-header {
        background: linear-gradient(180deg, #faf8ff 0%, var(--neo-card) 100%) !important;
        border-bottom: 1px solid var(--neo-border-light) !important;
    }

    /* ============================================
       TABLES — Premium styling
       ============================================ */
    .fi-ta-header-cell {
        background: linear-gradient(180deg, #faf8ff 0%, #f5f3ff 100%) !important;
        font-size: 0.6875rem !important;
        text-transform: uppercase !important;
        letter-spacing: 0.7px !important;
        color: var(--neo-text-muted) !important;
        font-weight: 700 !important;
        padding-top: 0.875rem !important;
        padding-bottom: 0.875rem !important;
    }

    .fi-ta-row {
        transition: var(--neo-transition) !important;
    }

    .fi-ta-row:hover {
        background-color: #faf8ff !important;
    }

    .fi-ta-cell {
        font-size: 0.8125rem !important;
        padding-top: 0.75rem !important;
        padding-bottom: 0.75rem !important;
    }

    /* ============================================
       STATS WIDGET — Gradient top bar
       ============================================ */
    .fi-wi-stats-overview-stat {
        border-radius: var(--neo-radius-lg) !important;
        box-shadow: var(--neo-shadow) !important;
        border: 1px solid var(--neo-border-light) !important;
        overflow: hidden;
        transition: var(--neo-transition) !important;
    }

    .fi-wi-stats-overview-stat:hover {
        transform: translateY(-2px);
        box-shadow: var(--neo-shadow-lg) !important;
    }

    /* ============================================
       BUTTONS — Gradient primary, smooth hover
       ============================================ */
    .fi-btn-primary,
    .fi-btn[data-color="primary"] {
        border-radius: 10px !important;
        font-weight: 600 !important;
        font-size: 0.8125rem !important;
        background: linear-gradient(135deg, var(--neo-primary), var(--neo-primary-light)) !important;
        box-shadow: 0 2px 8px rgba(108,58,237,0.25) !important;
        transition: var(--neo-transition) !important;
    }

    .fi-btn-primary:hover,
    .fi-btn[data-color="primary"]:hover {
        box-shadow: 0 4px 16px rgba(108,58,237,0.35) !important;
        transform: translateY(-1px);
    }

    /* Secondary/outline buttons */
    .fi-btn-outlined,
    .fi-btn[data-variant="outlined"] {
        border-radius: 10px !important;
        transition: var(--neo-transition) !important;
    }

    /* ============================================
       FORM INPUTS — Focus glow
       ============================================ */
    .fi-input,
    .fi-input-wrp {
        border-radius: 10px !important;
        transition: var(--neo-transition) !important;
        font-size: 0.875rem !important;
    }

    .fi-input:focus,
    .fi-input-wrp:focus-within {
        border-color: var(--neo-primary) !important;
        box-shadow: 0 0 0 4px var(--neo-primary-glow) !important;
    }

    .fi-fo-field-wrp label {
        font-size: 0.8125rem !important;
        font-weight: 600 !important;
        color: var(--neo-text) !important;
    }

    /* ============================================
       BADGES — Pill shape, consistent
       ============================================ */
    .fi-badge {
        border-radius: 8px !important;
        font-weight: 600 !important;
        font-size: 0.6875rem !important;
        letter-spacing: 0.01em !important;
    }

    /* ============================================
       NOTIFICATIONS — Premium toast
       ============================================ */
    .fi-no {
        border-radius: var(--neo-radius) !important;
        box-shadow: var(--neo-shadow-lg) !important;
    }

    /* ============================================
       PAGE HEADERS — Bold, tight
       ============================================ */
    .fi-header-heading {
        font-weight: 800 !important;
        font-size: 1.5rem !important;
        letter-spacing: -0.5px !important;
        color: var(--neo-text) !important;
    }

    .fi-breadcrumbs {
        font-size: 0.75rem !important;
        opacity: 0.8;
    }

    /* ============================================
       LOGIN PAGE — Branded, premium
       ============================================ */
    .fi-simple-layout {
        background: linear-gradient(135deg, #1e1b4b 0%, #312e81 50%, #4c1d95 100%) !important;
        position: relative;
    }

    .fi-simple-layout::before {
        content: '';
        position: absolute;
        inset: 0;
        background:
            radial-gradient(ellipse 80% 50% at 20% 80%, rgba(139,92,246,0.15) 0%, transparent 50%),
            radial-gradient(ellipse 60% 60% at 80% 20%, rgba(109,40,217,0.1) 0%, transparent 50%);
        pointer-events: none;
    }

    .fi-simple-main-ctn {
        border-radius: var(--neo-radius-xl) !important;
        box-shadow: 0 25px 60px rgba(0,0,0,0.3), 0 0 80px rgba(108,58,237,0.15) !important;
        border: 1px solid rgba(255,255,255,0.08) !important;
        backdrop-filter: blur(20px);
        background: rgba(255,255,255,0.97) !important;
        overflow: hidden;
    }

    .fi-simple-main-ctn::before {
        content: '';
        position: absolute;
        top: 0;
        left: 0;
        right: 0;
        height: 4px;
        background: linear-gradient(90deg, var(--neo-primary), var(--neo-primary-light), #a78bfa);
    }

    .fi-simple-main-ctn .fi-input {
        color: var(--neo-text) !important;
        background: var(--neo-card) !important;
        border: 1.5px solid var(--neo-border) !important;
    }

    .fi-simple-main-ctn .fi-input:focus {
        border-color: var(--neo-primary) !important;
    }

    .fi-simple-main-ctn .fi-btn-primary {
        width: 100%;
        padding: 0.75rem !important;
        font-size: 0.875rem !important;
    }

    /* Login brand text */
    .fi-simple-layout .fi-logo {
        margin-bottom: 0.5rem;
    }

    /* ============================================
       PAGINATION — Compact, clean
       ============================================ */
    .fi-pagination {
        font-size: 0.75rem !important;
    }

    .fi-pagination-item-btn {
        border-radius: 8px !important;
        transition: var(--neo-transition) !important;
    }

    /* ============================================
       TABS — Clean underline
       ============================================ */
    .fi-tabs-tab {
        font-size: 0.8125rem !important;
        font-weight: 500 !important;
        transition: var(--neo-transition) !important;
    }

    .fi-tabs-tab-active {
        font-weight: 600 !important;
    }

    /* ============================================
       MODAL — Premium overlay
       ============================================ */
    .fi-modal-window {
        border-radius: var(--neo-radius-xl) !important;
        box-shadow: var(--neo-shadow-lg) !important;
    }

    /* ============================================
       EMPTY STATES — Styled
       ============================================ */
    .fi-ta-empty-state {
        padding: 3rem !important;
    }

    .fi-ta-empty-state-icon {
        color: var(--neo-primary-light) !important;
        opacity: 0.4;
    }

    .fi-ta-empty-state-heading {
        font-weight: 700 !important;
        color: var(--neo-text) !important;
    }

    .fi-ta-empty-state-description {
        color: var(--neo-text-muted) !important;
        font-size: 0.8125rem !important;
    }

    /* ============================================
       ANIMATIONS
       ============================================ */
    @keyframes fadeInUp {
        from { opacity: 0; transform: translateY(16px); }
        to { opacity: 1; transform: translateY(0); }
    }

    @keyframes shimmer {
        0% { background-position: -200% 0; }
        100% { background-position: 200% 0; }
    }

    @keyframes pulse-dot {
        0%, 100% { opacity: 1; }
        50% { opacity: 0.5; }
    }

    /* ============================================
       DASHBOARD — KPI, Quick Actions, Widgets
       ============================================ */

    /* --- Greeting --- */
    .dash-header { margin-bottom: 2rem; }

    .dash-greeting {
        font-size: 1.75rem;
        font-weight: 800;
        color: var(--neo-text);
        letter-spacing: -0.5px;
        margin: 0;
    }

    .dash-greeting .gradient-name {
        background: linear-gradient(135deg, var(--neo-primary), #a78bfa);
        -webkit-background-clip: text;
        -webkit-text-fill-color: transparent;
        background-clip: text;
    }

    .dash-date {
        color: var(--neo-text-secondary);
        font-size: 0.8125rem;
        margin: 0.25rem 0 0;
        font-weight: 500;
    }

    /* --- KPI Cards --- */
    .kpi-grid {
        display: grid;
        grid-template-columns: repeat(4, 1fr);
        gap: 1.25rem;
        margin-bottom: 2rem;
    }

    @media (max-width: 1280px) { .kpi-grid { grid-template-columns: repeat(2, 1fr); } }
    @media (max-width: 640px) { .kpi-grid { grid-template-columns: 1fr; } }

    .kpi-card {
        background: var(--neo-card);
        border-radius: var(--neo-radius-xl);
        padding: 1.5rem;
        box-shadow: var(--neo-shadow);
        position: relative;
        overflow: hidden;
        transition: var(--neo-transition);
        animation: fadeInUp 0.5s ease forwards;
        border: 1px solid var(--neo-border-light);
    }

    .kpi-card:nth-child(1) { animation-delay: 0.05s; }
    .kpi-card:nth-child(2) { animation-delay: 0.1s; }
    .kpi-card:nth-child(3) { animation-delay: 0.15s; }
    .kpi-card:nth-child(4) { animation-delay: 0.2s; }

    .kpi-card:hover {
        transform: translateY(-3px);
        box-shadow: var(--neo-shadow-lg);
        border-color: rgba(108,58,237,0.12);
    }

    .kpi-card::before {
        content: '';
        position: absolute;
        top: 0; left: 0; right: 0;
        height: 4px;
    }

    .kpi-card.kpi-visitors::before { background: linear-gradient(90deg, #6C3AED, #8B5CF6); }
    .kpi-card.kpi-messages::before { background: linear-gradient(90deg, #06B6D4, #22D3EE); }
    .kpi-card.kpi-posts::before { background: linear-gradient(90deg, #10B981, #34D399); }
    .kpi-card.kpi-gdpr::before { background: linear-gradient(90deg, #EF4444, #F87171); }

    .kpi-top {
        display: flex;
        align-items: flex-start;
        justify-content: space-between;
        margin-bottom: 1rem;
    }

    .kpi-icon {
        width: 48px; height: 48px;
        border-radius: var(--neo-radius);
        display: flex; align-items: center; justify-content: center;
    }

    .kpi-icon svg { width: 24px !important; height: 24px !important; }

    .kpi-visitors .kpi-icon { background: #EDE9FE; color: #6C3AED; }
    .kpi-messages .kpi-icon { background: #CFFAFE; color: #06B6D4; }
    .kpi-posts .kpi-icon { background: #D1FAE5; color: #10B981; }
    .kpi-gdpr .kpi-icon { background: #FEE2E2; color: #EF4444; }

    .kpi-trend {
        display: inline-flex;
        align-items: center;
        gap: 0.25rem;
        font-size: 0.6875rem;
        font-weight: 700;
        padding: 0.2rem 0.5rem;
        border-radius: 8px;
    }

    .kpi-trend.up { background: #D1FAE5; color: #059669; }
    .kpi-trend.down { background: #FEE2E2; color: #DC2626; }
    .kpi-trend.neutral { background: #F3F4F6; color: #6B7280; }

    .kpi-value {
        font-size: 2rem;
        font-weight: 800;
        color: var(--neo-text);
        letter-spacing: -1px;
        line-height: 1;
    }

    .kpi-label {
        color: var(--neo-text-secondary);
        font-size: 0.8125rem;
        font-weight: 500;
        margin-top: 0.25rem;
    }

    /* Sparkline */
    .kpi-sparkline {
        margin-top: 1rem;
        height: 40px;
        width: 100%;
    }

    .kpi-sparkline svg {
        width: 100%; height: 100%;
        display: block;
    }

    /* --- Section headers --- */
    .section-header {
        display: flex;
        align-items: center;
        justify-content: space-between;
        margin-bottom: 1.25rem;
    }

    .section-title {
        font-size: 1.125rem;
        font-weight: 700;
        color: var(--neo-text);
        letter-spacing: -0.3px;
    }

    /* --- Quick Actions --- */
    .quick-actions {
        display: grid;
        grid-template-columns: repeat(4, 1fr);
        gap: 1rem;
        margin-bottom: 2rem;
    }

    @media (max-width: 1280px) { .quick-actions { grid-template-columns: repeat(2, 1fr); } }
    @media (max-width: 640px) { .quick-actions { grid-template-columns: 1fr; } }

    .quick-action {
        background: var(--neo-card);
        border-radius: var(--neo-radius-lg);
        padding: 1.25rem;
        display: flex;
        align-items: center;
        gap: 0.875rem;
        box-shadow: var(--neo-shadow-xs);
        transition: var(--neo-transition);
        text-decoration: none;
        border: 2px solid transparent;
        animation: fadeInUp 0.5s ease forwards;
        opacity: 0;
    }

    .quick-action:nth-child(1) { animation-delay: 0.25s; }
    .quick-action:nth-child(2) { animation-delay: 0.3s; }
    .quick-action:nth-child(3) { animation-delay: 0.35s; }
    .quick-action:nth-child(4) { animation-delay: 0.4s; }

    .quick-action:hover {
        transform: translateY(-3px);
        box-shadow: var(--neo-shadow);
        border-color: var(--neo-primary);
    }

    .quick-action-icon {
        width: 44px; height: 44px;
        border-radius: var(--neo-radius);
        display: flex; align-items: center; justify-content: center;
        flex-shrink: 0;
    }

    .quick-action-icon svg { width: 20px; height: 20px; color: white; }

    .quick-action:nth-child(1) .quick-action-icon { background: linear-gradient(135deg, #8B5CF6, #A78BFA); }
    .quick-action:nth-child(2) .quick-action-icon { background: linear-gradient(135deg, #3B82F6, #60A5FA); }
    .quick-action:nth-child(3) .quick-action-icon { background: linear-gradient(135deg, #06B6D4, #22D3EE); }
    .quick-action:nth-child(4) .quick-action-icon { background: linear-gradient(135deg, #10B981, #34D399); }

    .quick-action-title {
        font-size: 0.875rem;
        font-weight: 600;
        color: var(--neo-text);
        margin: 0;
    }

    .quick-action-desc {
        font-size: 0.6875rem;
        color: var(--neo-text-muted);
        margin: 0.125rem 0 0;
    }

    /* --- Content grid & Cards --- */
    .content-grid {
        display: grid;
        grid-template-columns: 1.6fr 1fr;
        gap: 1.5rem;
        margin-bottom: 2rem;
    }

    @media (max-width: 1280px) { .content-grid { grid-template-columns: 1fr; } }

    .dash-card {
        background: var(--neo-card);
        border-radius: var(--neo-radius-xl);
        box-shadow: var(--neo-shadow);
        overflow: hidden;
        border: 1px solid var(--neo-border-light);
        animation: fadeInUp 0.5s ease forwards;
        opacity: 0;
        animation-delay: 0.45s;
    }

    .dash-card:nth-child(2) { animation-delay: 0.5s; }

    .dash-card-header {
        padding: 1rem 1.5rem;
        display: flex;
        align-items: center;
        justify-content: space-between;
        border-bottom: 1px solid var(--neo-border-light);
        background: linear-gradient(180deg, #faf8ff 0%, var(--neo-card) 100%);
    }

    .dash-card-title {
        font-size: 0.875rem;
        font-weight: 700;
        color: var(--neo-text);
        letter-spacing: -0.2px;
    }

    .dash-card-link {
        font-size: 0.75rem;
        font-weight: 600;
        color: var(--neo-primary);
        text-decoration: none;
        display: flex;
        align-items: center;
        gap: 0.25rem;
        transition: gap 0.2s;
    }

    .dash-card-link:hover { gap: 0.5rem; }

    .dash-card-body { padding: 1.25rem 1.5rem; }

    /* --- Messages list --- */
    .message-item {
        display: flex;
        align-items: flex-start;
        gap: 0.625rem;
        padding: 0.75rem 0;
        border-bottom: 1px solid var(--neo-border-light);
        transition: var(--neo-transition);
    }

    .message-item:last-child { border-bottom: none; }

    .message-item:hover {
        background: #faf8ff;
        margin: 0 -1.5rem;
        padding-left: 1.5rem;
        padding-right: 1.5rem;
        border-radius: var(--neo-radius);
    }

    .msg-status {
        width: 8px; height: 8px;
        border-radius: 50%;
        background: var(--neo-primary);
        flex-shrink: 0;
        margin-top: 0.375rem;
        animation: pulse-dot 2s ease-in-out infinite;
    }

    .msg-status.read { background: transparent; animation: none; }

    .msg-avatar {
        width: 36px; height: 36px;
        border-radius: 50%;
        display: flex; align-items: center; justify-content: center;
        font-weight: 700; font-size: 0.75rem;
        color: white; flex-shrink: 0;
    }

    .msg-content { flex: 1; min-width: 0; }

    .msg-name { font-size: 0.8125rem; font-weight: 600; color: var(--neo-text); }

    .msg-preview {
        font-size: 0.6875rem;
        color: var(--neo-text-muted);
        margin-top: 0.125rem;
        white-space: nowrap; overflow: hidden; text-overflow: ellipsis;
    }

    .msg-time {
        font-size: 0.625rem;
        color: var(--neo-text-muted);
        white-space: nowrap;
        margin-top: 0.125rem;
        font-weight: 500;
    }

    /* --- Activity timeline --- */
    .activity-item {
        display: flex;
        align-items: flex-start;
        gap: 0.75rem;
        padding: 0.625rem 0;
        position: relative;
    }

    .activity-item:not(:last-child)::after {
        content: '';
        position: absolute;
        left: 15px; top: 2.25rem; bottom: -0.25rem;
        width: 2px;
        background: linear-gradient(180deg, var(--neo-border), transparent);
    }

    .activity-icon {
        width: 32px; height: 32px;
        border-radius: 50%;
        display: flex; align-items: center; justify-content: center;
        flex-shrink: 0; z-index: 1;
    }

    .activity-icon svg { width: 14px; height: 14px; }
    .activity-icon.create { background: #D1FAE5; color: #059669; }
    .activity-icon.edit { background: #DBEAFE; color: #2563EB; }
    .activity-icon.delete { background: #FEE2E2; color: #DC2626; }
    .activity-icon.login { background: #EDE9FE; color: #6C3AED; }

    .activity-text { flex: 1; }
    .activity-desc { font-size: 0.8125rem; color: var(--neo-text); line-height: 1.4; }
    .activity-desc strong { font-weight: 600; }
    .activity-time { font-size: 0.625rem; color: var(--neo-text-muted); margin-top: 0.125rem; font-weight: 500; }

    /* --- Pages table --- */
    .pages-table { width: 100%; border-collapse: separate; border-spacing: 0; }

    .pages-table th {
        text-align: left;
        font-size: 0.625rem; font-weight: 700;
        text-transform: uppercase; letter-spacing: 0.7px;
        color: var(--neo-text-muted);
        padding: 0 0.75rem 0.625rem;
        border-bottom: 1px solid var(--neo-border);
    }

    .pages-table td {
        padding: 0.625rem 0.75rem;
        font-size: 0.8125rem;
        border-bottom: 1px solid var(--neo-border-light);
        vertical-align: middle;
    }

    .pages-table tr { transition: var(--neo-transition); }
    .pages-table tr:hover td { background: #faf8ff; }

    .page-name { font-weight: 600; color: var(--neo-text); }

    .status-badge {
        display: inline-flex; align-items: center; gap: 0.25rem;
        padding: 0.2rem 0.5rem; border-radius: 20px;
        font-size: 0.625rem; font-weight: 600;
    }

    .status-badge.published { background: #D1FAE5; color: #059669; }
    .status-badge.draft { background: #FEF3C7; color: #D97706; }

    .status-dot { width: 6px; height: 6px; border-radius: 50%; }
    .published .status-dot { background: #059669; }
    .draft .status-dot { background: #D97706; }

    /* --- Bottom grid --- */
    .bottom-grid {
        display: grid;
        grid-template-columns: 1fr 1fr;
        gap: 1.5rem;
    }

    @media (max-width: 1280px) { .bottom-grid { grid-template-columns: 1fr; } }

    /* --- Summary stat block --- */
    .stat-block {
        text-align: center;
        padding: 1.25rem;
        border-radius: var(--neo-radius-lg);
        transition: var(--neo-transition);
    }

    .stat-block:hover {
        transform: scale(1.03);
    }

    .stat-block-value {
        font-size: 2rem;
        font-weight: 800;
        line-height: 1;
    }

    .stat-block-label {
        font-size: 0.6875rem;
        color: var(--neo-text-secondary);
        margin-top: 0.375rem;
        font-weight: 500;
    }

    /* --- Empty state (dashboard) --- */
    .dash-empty {
        text-align: center;
        padding: 2.5rem 1.5rem;
        color: var(--neo-text-muted);
    }

    .dash-empty svg {
        width: 2.5rem; height: 2.5rem;
        margin: 0 auto 0.75rem;
        opacity: 0.25;
    }

    .dash-empty p {
        font-size: 0.8125rem;
        font-weight: 500;
    }
</style>
