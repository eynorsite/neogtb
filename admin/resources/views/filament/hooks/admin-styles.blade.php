<style>
    /* ============================================
       NEOGTB ADMIN DESIGN SYSTEM
       Light mode only — clean, professional
       ============================================ */

    :root {
        --neo-primary: #1B3A5C;
        --neo-primary-light: #e6f0f7;
        --neo-accent: #2D8B4E;
        --neo-sidebar-bg: #1A1D2E;
        --neo-sidebar-text: #A8ADBF;
        --neo-sidebar-hover: #252840;
        --neo-bg: #F8F9FC;
        --neo-border: #E8EBF0;
        --neo-card-radius: 12px;
        --neo-card-shadow: 0 1px 3px rgba(0, 0, 0, 0.06);
    }

    /* ---------- SIDEBAR ---------- */
    .fi-sidebar {
        background-color: var(--neo-sidebar-bg) !important;
        border-right: none !important;
    }

    .fi-sidebar .fi-sidebar-header {
        border-bottom-color: rgba(255, 255, 255, 0.08) !important;
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
        color: rgba(255, 255, 255, 0.35) !important;
        font-size: 0.65rem !important;
        text-transform: uppercase !important;
        letter-spacing: 0.08em !important;
    }

    .fi-sidebar .fi-sidebar-item a,
    .fi-sidebar .fi-sidebar-item button {
        color: var(--neo-sidebar-text) !important;
        border-radius: 8px !important;
        transition: all 0.15s ease !important;
    }

    .fi-sidebar .fi-sidebar-item a:hover,
    .fi-sidebar .fi-sidebar-item button:hover {
        background-color: var(--neo-sidebar-hover) !important;
        color: #ffffff !important;
    }

    .fi-sidebar .fi-sidebar-item.fi-active a,
    .fi-sidebar .fi-sidebar-item.fi-active button,
    .fi-sidebar .fi-sidebar-item a[aria-current="page"] {
        background-color: rgba(45, 139, 78, 0.15) !important;
        color: #4CAF50 !important;
        font-weight: 600 !important;
        border-left: 3px solid var(--neo-accent) !important;
    }

    .fi-sidebar .fi-sidebar-item svg {
        color: inherit !important;
        opacity: 0.7;
    }

    .fi-sidebar .fi-sidebar-item.fi-active svg,
    .fi-sidebar .fi-sidebar-item a[aria-current="page"] svg {
        opacity: 1;
        color: #4CAF50 !important;
    }

    .fi-sidebar .fi-icon-btn {
        color: var(--neo-sidebar-text) !important;
    }

    .fi-sidebar .fi-sidebar-group > button svg {
        color: rgba(255, 255, 255, 0.3) !important;
    }

    /* ---------- BODY / TOPBAR ---------- */
    .fi-body {
        background-color: var(--neo-bg) !important;
    }

    .fi-topbar {
        background-color: #ffffff !important;
        border-bottom: 1px solid var(--neo-border) !important;
        box-shadow: 0 1px 2px rgba(0, 0, 0, 0.04) !important;
    }

    /* ---------- CARDS ---------- */
    .fi-section {
        border-radius: var(--neo-card-radius) !important;
        box-shadow: var(--neo-card-shadow) !important;
        border-color: var(--neo-border) !important;
    }

    /* ---------- TABLES ---------- */
    .fi-ta-header-cell {
        background-color: #F1F3F8 !important;
        font-size: 0.75rem !important;
        text-transform: uppercase !important;
        letter-spacing: 0.03em !important;
        color: #64748b !important;
    }

    .fi-ta-row:hover {
        background-color: var(--neo-bg) !important;
    }

    /* ---------- STATS ---------- */
    .fi-wi-stats-overview-stat {
        border-radius: var(--neo-card-radius) !important;
        box-shadow: var(--neo-card-shadow) !important;
        border: 1px solid var(--neo-border) !important;
    }

    /* ---------- BUTTONS ---------- */
    .fi-btn-primary,
    .fi-btn[data-color="primary"] {
        border-radius: 8px !important;
        font-weight: 600 !important;
    }

    /* ---------- FORM INPUTS ---------- */
    .fi-input,
    .fi-input-wrp {
        border-radius: 8px !important;
        transition: all 0.15s ease !important;
    }

    .fi-input:focus,
    .fi-input-wrp:focus-within {
        border-color: var(--neo-primary) !important;
        box-shadow: 0 0 0 3px rgba(27, 58, 92, 0.1) !important;
        outline: none !important;
    }

    /* ---------- BADGES ---------- */
    .fi-badge {
        border-radius: 6px !important;
        font-weight: 600 !important;
        font-size: 0.7rem !important;
    }

    /* ---------- MISC ---------- */
    .fi-no {
        border-radius: var(--neo-card-radius) !important;
    }

    .fi-header-heading {
        font-weight: 800 !important;
        letter-spacing: -0.01em !important;
    }

    .fi-breadcrumbs {
        font-size: 0.8rem !important;
    }

    .fi-simple-layout {
        background-color: var(--neo-bg) !important;
    }

    .fi-simple-main-ctn {
        border-radius: 16px !important;
        box-shadow: 0 4px 24px rgba(0, 0, 0, 0.08) !important;
    }

    .fi-pagination {
        font-size: 0.8rem !important;
    }

    /* ============================================
       DASHBOARD
       ============================================ */

    /* --- Header --- */
    .dash-header {
        display: flex;
        align-items: center;
        justify-content: space-between;
        gap: 1rem;
        padding: 1.25rem 1.5rem;
        background: linear-gradient(135deg, #1B3A5C 0%, #2D5F8A 60%, #1a6b4a 100%);
        border-radius: 14px;
        margin-bottom: 1.25rem;
    }

    .dash-greeting {
        font-size: 1.15rem;
        font-weight: 700;
        color: #ffffff;
        margin: 0;
        letter-spacing: -0.01em;
    }

    .dash-date {
        font-size: 0.8rem;
        color: rgba(255, 255, 255, 0.55);
        margin: 0.2rem 0 0;
    }

    .dash-header-right {
        display: flex;
        align-items: center;
        gap: 0.75rem;
        flex-shrink: 0;
    }

    .dash-alerts {
        display: flex;
        gap: 0.5rem;
    }

    .dash-alert {
        display: inline-flex;
        align-items: center;
        gap: 0.4rem;
        padding: 0.35rem 0.75rem;
        border-radius: 8px;
        font-size: 0.75rem;
        font-weight: 600;
        text-decoration: none;
        transition: opacity 0.15s;
    }

    .dash-alert:hover {
        opacity: 0.85;
    }

    .dash-alert-icon {
        width: 0.9rem;
        height: 0.9rem;
    }

    .dash-alert-danger {
        background: rgba(239, 68, 68, 0.9);
        color: #ffffff;
    }

    .dash-alert-warning {
        background: rgba(245, 158, 11, 0.9);
        color: #ffffff;
    }

    .dash-site-link {
        display: inline-flex;
        align-items: center;
        gap: 0.4rem;
        padding: 0.4rem 0.9rem;
        border-radius: 8px;
        font-size: 0.78rem;
        font-weight: 600;
        text-decoration: none;
        background: rgba(255, 255, 255, 0.12);
        color: rgba(255, 255, 255, 0.8);
        border: 1px solid rgba(255, 255, 255, 0.15);
        transition: all 0.15s;
    }

    .dash-site-link:hover {
        background: rgba(255, 255, 255, 0.22);
        color: #ffffff;
    }

    @media (max-width: 768px) {
        .dash-header {
            flex-direction: column;
            align-items: flex-start;
            padding: 1rem 1.15rem;
        }

        .dash-header-right {
            flex-wrap: wrap;
        }
    }

    /* --- Section label --- */
    .dash-section-label {
        font-size: 0.7rem;
        font-weight: 700;
        text-transform: uppercase;
        letter-spacing: 0.06em;
        color: #94a3b8;
        margin: 1.25rem 0 0.65rem 0.15rem;
    }

    /* --- Shortcuts --- */
    .dash-shortcuts {
        display: grid;
        grid-template-columns: repeat(3, 1fr);
        gap: 0.65rem;
    }

    @media (max-width: 768px) {
        .dash-shortcuts {
            grid-template-columns: 1fr;
        }
    }

    @media (min-width: 769px) and (max-width: 1024px) {
        .dash-shortcuts {
            grid-template-columns: repeat(2, 1fr);
        }
    }

    .dash-shortcut {
        display: flex;
        align-items: center;
        gap: 0.85rem;
        padding: 0.75rem 1rem;
        border-radius: 10px;
        background: #ffffff;
        border: 1px solid var(--neo-border);
        text-decoration: none;
        transition: all 0.15s ease;
    }

    .dash-shortcut:hover {
        border-color: #bfdbfe;
        box-shadow: 0 2px 8px rgba(27, 58, 92, 0.07);
        transform: translateY(-1px);
    }

    .dash-shortcut-primary {
        padding: 1rem 1.15rem;
    }

    .dash-shortcut-icon {
        flex-shrink: 0;
        width: 36px;
        height: 36px;
        border-radius: 9px;
        display: flex;
        align-items: center;
        justify-content: center;
    }

    .dash-shortcut-primary .dash-shortcut-icon {
        width: 40px;
        height: 40px;
    }

    .dash-shortcut-text {
        flex: 1;
        min-width: 0;
    }

    .dash-shortcut-title {
        font-size: 0.84rem;
        font-weight: 600;
        color: #1e293b;
        margin: 0;
        line-height: 1.3;
    }

    .dash-shortcut-desc {
        font-size: 0.72rem;
        color: #64748b;
        margin: 0.1rem 0 0;
        line-height: 1.3;
    }

    .dash-shortcut-arrow {
        width: 1rem;
        height: 1rem;
        color: #cbd5e1;
        flex-shrink: 0;
        transition: color 0.15s, transform 0.15s;
    }

    .dash-shortcut:hover .dash-shortcut-arrow {
        color: #64748b;
        transform: translateX(2px);
    }

    /* Icon colors */
    .dash-icon-blue {
        background: #EFF6FF;
        color: #2563EB;
    }

    .dash-icon-green {
        background: #F0FDF4;
        color: #16A34A;
    }

    .dash-icon-amber {
        background: #FFFBEB;
        color: #D97706;
    }

    .dash-icon-violet {
        background: #F5F3FF;
        color: #7C3AED;
    }

    .dash-icon-rose {
        background: #FFF1F2;
        color: #E11D48;
    }

    .dash-icon-slate {
        background: #F1F5F9;
        color: #475569;
    }
</style>
