<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Éditeur de bricks — NeoGTB Admin</title>
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;500;600;700;800&display=swap" rel="stylesheet">
    <script src="https://cdn.jsdelivr.net/npm/sortablejs@1.15.6/Sortable.min.js"></script>
    <?php echo \Livewire\Mechanisms\FrontendAssets\FrontendAssets::styles(); ?>

    <style>
        * { margin: 0; padding: 0; box-sizing: border-box; }
        body {
            font-family: 'Inter', -apple-system, BlinkMacSystemFont, sans-serif;
            background: #F1F5F9;
            color: #1E293B;
            height: 100vh;
            overflow: hidden;
        }

        /* --- TOPBAR --- */
        .topbar {
            height: 56px;
            background: #1A1D2E;
            display: flex;
            align-items: center;
            justify-content: space-between;
            padding: 0 20px;
            color: white;
            box-shadow: 0 1px 3px rgba(0,0,0,0.2);
            z-index: 50;
        }
        .topbar-brand { font-weight: 800; font-size: 15px; }
        .topbar-page { font-weight: 600; font-size: 14px; opacity: 0.9; }
        .topbar-preview-btn {
            color: #1A1D2E;
            background: #4CAF50;
            font-weight: 700;
            font-size: 13px;
            padding: 6px 16px;
            border-radius: 6px;
            border: none;
            cursor: pointer;
            transition: all 0.15s;
        }
        .topbar-preview-btn:hover { background: #43A047; }
        .topbar a {
            color: rgba(255,255,255,0.7);
            text-decoration: none;
            font-size: 13px;
            padding: 6px 14px;
            border-radius: 6px;
            border: 1px solid rgba(255,255,255,0.2);
            transition: all 0.15s;
        }
        .topbar a:hover { background: rgba(255,255,255,0.1); color: white; }
        .topbar-actions { display: flex; gap: 8px; align-items: center; }
        .btn-save {
            background: #0F6BAF;
            color: white;
            border: none;
            padding: 7px 18px;
            border-radius: 6px;
            font-weight: 600;
            font-size: 13px;
            cursor: pointer;
            transition: background 0.15s;
        }
        .btn-save:hover { background: #0d5f9c; }

        /* --- 3 COLUMNS --- */
        .editor-container {
            display: flex;
            height: calc(100vh - 56px);
            overflow: hidden;
        }

        /* LEFT PANEL */
        .panel-left {
            width: 260px;
            min-width: 260px;
            background: white;
            border-right: 1px solid #E2E8F0;
            overflow-y: auto;
            padding: 16px;
        }
        .panel-title {
            font-size: 11px;
            font-weight: 700;
            text-transform: uppercase;
            letter-spacing: 0.08em;
            color: #94A3B8;
            margin-bottom: 12px;
        }
        .brick-category {
            font-size: 10px;
            font-weight: 700;
            text-transform: uppercase;
            letter-spacing: 0.1em;
            color: #CBD5E1;
            margin: 16px 0 6px;
        }
        .brick-btn {
            display: flex;
            align-items: center;
            gap: 10px;
            width: 100%;
            padding: 8px 10px;
            border: 1px solid transparent;
            border-radius: 8px;
            background: none;
            cursor: pointer;
            text-align: left;
            transition: all 0.15s;
            font-family: inherit;
        }
        .brick-btn:hover { background: #F1F5F9; border-color: #E2E8F0; }
        .brick-btn .icon { font-size: 18px; flex-shrink: 0; }
        .brick-btn .label { font-size: 13px; font-weight: 600; color: #334155; }
        .brick-btn .desc { font-size: 10px; color: #94A3B8; line-height: 1.3; }

        /* CENTER PANEL */
        .panel-center {
            flex: 1;
            overflow-y: auto;
            padding: 24px;
            background: #F1F5F9;
        }
        .canvas-header {
            font-size: 11px;
            font-weight: 700;
            text-transform: uppercase;
            letter-spacing: 0.08em;
            color: #94A3B8;
            margin-bottom: 12px;
        }
        .brick-card {
            background: white;
            border: 2px solid #E2E8F0;
            border-radius: 10px;
            padding: 14px;
            margin-bottom: 8px;
            cursor: pointer;
            transition: all 0.15s;
            display: flex;
            align-items: center;
            justify-content: space-between;
        }
        .brick-card:hover { border-color: #CBD5E1; box-shadow: 0 2px 8px rgba(0,0,0,0.05); }
        .brick-card.selected { border-color: #0F6BAF; background: #F0F7FF; box-shadow: 0 0 0 3px rgba(15,107,175,0.1); }
        .brick-card.hidden { opacity: 0.35; }
        .brick-card-left { display: flex; align-items: center; gap: 12px; }
        .drag-handle {
            cursor: grab;
            color: #CBD5E1;
            padding: 4px;
            border-radius: 4px;
            transition: color 0.15s;
        }
        .drag-handle:hover { color: #64748B; }
        .drag-handle:active { cursor: grabbing; }
        .brick-card-icon {
            width: 36px;
            height: 36px;
            border-radius: 8px;
            background: #F1F5F9;
            display: flex;
            align-items: center;
            justify-content: center;
            font-size: 16px;
        }
        .brick-card-name { font-weight: 600; font-size: 13px; color: #1E293B; }
        .brick-card-preview { font-size: 11px; color: #94A3B8; margin-top: 2px; }
        .brick-card-actions { display: flex; gap: 2px; opacity: 0; transition: opacity 0.15s; }
        .brick-card:hover .brick-card-actions { opacity: 1; }
        .brick-action {
            width: 28px; height: 28px;
            display: flex; align-items: center; justify-content: center;
            border: none; background: none; cursor: pointer;
            border-radius: 6px; color: #94A3B8; font-size: 14px;
            transition: all 0.15s;
        }
        .brick-action:hover { background: #F1F5F9; color: #1E293B; }
        .brick-action.danger:hover { background: #FEF2F2; color: #EF4444; }

        .canvas-empty {
            text-align: center;
            padding: 60px 20px;
            color: #94A3B8;
        }
        .canvas-empty .icon { font-size: 40px; margin-bottom: 12px; }

        .sortable-ghost { opacity: 0.3; }
        .sortable-drag { box-shadow: 0 8px 24px rgba(0,0,0,0.12); transform: rotate(0.5deg); }

        /* RIGHT PANEL */
        .panel-right {
            width: 340px;
            min-width: 340px;
            background: white;
            border-left: 1px solid #E2E8F0;
            overflow-y: auto;
            padding: 20px;
        }
        .props-header {
            display: flex;
            align-items: center;
            justify-content: space-between;
            margin-bottom: 16px;
            padding-bottom: 12px;
            border-bottom: 1px solid #F1F5F9;
        }
        .props-title {
            font-size: 14px;
            font-weight: 700;
            color: #1E293B;
        }
        .props-section {
            font-size: 10px;
            font-weight: 700;
            text-transform: uppercase;
            letter-spacing: 0.1em;
            color: #94A3B8;
            margin: 16px 0 8px;
            display: flex;
            align-items: center;
            gap: 8px;
        }
        .props-section::after {
            content: '';
            flex: 1;
            height: 1px;
            background: #F1F5F9;
        }
        .field-group { margin-bottom: 12px; }
        .field-label {
            font-size: 12px;
            font-weight: 600;
            color: #64748B;
            margin-bottom: 4px;
        }
        .field-input {
            width: 100%;
            padding: 8px 12px;
            border: 1px solid #E2E8F0;
            border-radius: 8px;
            font-size: 13px;
            font-family: inherit;
            background: #F8FAFC;
            transition: all 0.15s;
        }
        .field-input:focus {
            border-color: #0F6BAF;
            box-shadow: 0 0 0 3px rgba(15,107,175,0.1);
            outline: none;
            background: white;
        }
        textarea.field-input { resize: vertical; min-height: 72px; }
        .field-complex {
            padding: 8px 12px;
            border: 1px dashed #E2E8F0;
            border-radius: 8px;
            font-size: 11px;
            color: #94A3B8;
            background: #FAFBFC;
        }
        .panel-empty {
            text-align: center;
            padding: 80px 20px;
            color: #94A3B8;
        }
        .panel-empty .icon { font-size: 32px; margin-bottom: 8px; }

        /* Notification toast */
        .toast {
            position: fixed;
            bottom: 20px;
            right: 20px;
            background: #1E293B;
            color: white;
            padding: 10px 20px;
            border-radius: 8px;
            font-size: 13px;
            font-weight: 500;
            z-index: 100;
            animation: slideIn 0.3s ease, fadeOut 0.3s ease 2.5s forwards;
        }
        @keyframes slideIn { from { transform: translateY(20px); opacity: 0; } to { transform: translateY(0); opacity: 1; } }
        @keyframes fadeOut { from { opacity: 1; } to { opacity: 0; } }
    </style>
</head>
<body>
    <?php echo e($slot); ?>

    <?php echo \Livewire\Mechanisms\FrontendAssets\FrontendAssets::scripts(); ?>

</body>
</html>
<?php /**PATH /var/www/neogtb/admin/resources/views/livewire/layouts/brick-editor-layout.blade.php ENDPATH**/ ?>