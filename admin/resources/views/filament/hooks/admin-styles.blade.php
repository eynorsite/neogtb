<style>
    /* ============================================
       NEOGTB ADMIN DESIGN SYSTEM
       ============================================ */

    :root {
        --neogtb-primary: #1B3A5C;
        --neogtb-primary-light: #e6f0f7;
        --neogtb-sidebar-bg: #1A1D2E;
        --neogtb-sidebar-text: #A8ADBF;
        --neogtb-sidebar-active: #2D8B4E;
        --neogtb-sidebar-hover: #252840;
        --neogtb-card-shadow: 0 1px 3px rgba(0,0,0,0.08);
        --neogtb-card-radius: 12px;
        --neogtb-bg: #F8F9FC;
    }

    /* ---------- SIDEBAR SOMBRE ---------- */
    .fi-sidebar {
        background-color: var(--neogtb-sidebar-bg) !important;
        border-right: none !important;
    }

    .fi-sidebar .fi-sidebar-header {
        border-bottom-color: rgba(255,255,255,0.08) !important;
    }

    /* Brand name en blanc */
    .fi-sidebar .fi-sidebar-header a,
    .fi-sidebar .fi-sidebar-header span,
    .fi-sidebar-header .fi-logo span,
    .fi-sidebar-header a span {
        color: #ffffff !important;
        font-weight: 700 !important;
    }

    /* Navigation groups */
    .fi-sidebar .fi-sidebar-group-label,
    .fi-sidebar .fi-sidebar-nav .fi-sidebar-group > button > span {
        color: rgba(255,255,255,0.35) !important;
        font-size: 0.65rem !important;
        text-transform: uppercase !important;
        letter-spacing: 0.08em !important;
    }

    /* Navigation items */
    .fi-sidebar .fi-sidebar-item a,
    .fi-sidebar .fi-sidebar-item button {
        color: var(--neogtb-sidebar-text) !important;
        border-radius: 8px !important;
        transition: all 0.15s ease !important;
    }

    .fi-sidebar .fi-sidebar-item a:hover,
    .fi-sidebar .fi-sidebar-item button:hover {
        background-color: var(--neogtb-sidebar-hover) !important;
        color: #ffffff !important;
    }

    /* Active item */
    .fi-sidebar .fi-sidebar-item.fi-active a,
    .fi-sidebar .fi-sidebar-item.fi-active button,
    .fi-sidebar .fi-sidebar-item a[aria-current="page"] {
        background-color: rgba(45, 139, 78, 0.15) !important;
        color: #4CAF50 !important;
        font-weight: 600 !important;
        border-left: 3px solid var(--neogtb-sidebar-active) !important;
    }

    /* Sidebar icons */
    .fi-sidebar .fi-sidebar-item svg {
        color: inherit !important;
        opacity: 0.7;
    }

    .fi-sidebar .fi-sidebar-item.fi-active svg,
    .fi-sidebar .fi-sidebar-item a[aria-current="page"] svg {
        opacity: 1;
        color: #4CAF50 !important;
    }

    /* Collapse button */
    .fi-sidebar .fi-icon-btn {
        color: var(--neogtb-sidebar-text) !important;
    }

    /* Sidebar group chevrons */
    .fi-sidebar .fi-sidebar-group > button svg {
        color: rgba(255,255,255,0.3) !important;
    }

    /* ---------- FOND GENERAL ---------- */
    .fi-body {
        background-color: var(--neogtb-bg) !important;
    }

    /* ---------- TOP BAR ---------- */
    .fi-topbar {
        background-color: #ffffff !important;
        border-bottom: 1px solid #E8EBF0 !important;
        box-shadow: 0 1px 2px rgba(0,0,0,0.04) !important;
    }

    /* ---------- CARDS / SECTIONS ---------- */
    .fi-section {
        border-radius: var(--neogtb-card-radius) !important;
        box-shadow: var(--neogtb-card-shadow) !important;
        border-color: #E8EBF0 !important;
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
        background-color: #F8F9FC !important;
    }

    /* ---------- STATS WIDGETS ---------- */
    .fi-wi-stats-overview-stat {
        border-radius: var(--neogtb-card-radius) !important;
        box-shadow: var(--neogtb-card-shadow) !important;
        border: 1px solid #E8EBF0 !important;
    }

    /* ---------- BUTTONS ---------- */
    .fi-btn-primary,
    .fi-btn[data-color="primary"] {
        border-radius: 8px !important;
        font-weight: 600 !important;
    }

    /* ---------- FORM INPUTS ---------- */
    .fi-input,
    .fi-input-wrp,
    input[type="text"],
    input[type="email"],
    input[type="password"],
    input[type="url"],
    input[type="tel"],
    input[type="number"],
    textarea,
    select {
        border: 1px solid #CBD5E1 !important;
        border-radius: 8px !important;
        background-color: #ffffff !important;
        transition: all 0.15s ease !important;
    }

    .fi-input:focus,
    .fi-input-wrp:focus-within,
    input:focus,
    textarea:focus,
    select:focus {
        border-color: var(--neogtb-primary) !important;
        box-shadow: 0 0 0 3px rgba(15, 107, 175, 0.12) !important;
        outline: none !important;
    }

    /* Ensure inputs inside Filament wrappers are visible */
    .fi-fo-field-wrp input,
    .fi-fo-field-wrp textarea,
    .fi-fo-field-wrp select {
        border: 1px solid #CBD5E1 !important;
        padding: 0.5rem 0.75rem !important;
        border-radius: 8px !important;
    }

    /* ---------- BADGES ---------- */
    .fi-badge {
        border-radius: 6px !important;
        font-weight: 600 !important;
        font-size: 0.7rem !important;
    }

    /* ---------- NOTIFICATIONS / TOASTS ---------- */
    .fi-no {
        border-radius: var(--neogtb-card-radius) !important;
    }

    /* ---------- PAGE HEADERS ---------- */
    .fi-header-heading {
        font-weight: 800 !important;
        letter-spacing: -0.01em !important;
    }

    /* ---------- BREADCRUMBS ---------- */
    .fi-breadcrumbs {
        font-size: 0.8rem !important;
    }

    /* ---------- LOGIN PAGE ---------- */
    .fi-simple-layout {
        background-color: var(--neogtb-bg) !important;
    }

    .fi-simple-main-ctn {
        border-radius: 16px !important;
        box-shadow: 0 4px 24px rgba(0,0,0,0.08) !important;
    }

    /* ---------- PAGINATION ---------- */
    .fi-pagination {
        font-size: 0.8rem !important;
    }
</style>
