<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Preview · {{ $page->name ?? $page->slug }}</title>
    @vite(['resources/css/app.css', 'resources/js/app.js'])
    <style>
        [data-brick-id] {
            position: relative;
            transition: outline 0.2s ease;
        }
        [data-brick-id]:hover {
            outline: 2px dashed rgba(108, 58, 237, 0.4);
            outline-offset: -2px;
        }
        [data-brick-id].brick-just-updated {
            outline: 2px solid rgba(16, 185, 129, 0.8);
            outline-offset: -2px;
            animation: brickFlash 1.5s ease-out;
        }
        @keyframes brickFlash {
            0% { background-color: rgba(16, 185, 129, 0.15); }
            100% { background-color: transparent; }
        }
    </style>
</head>
<body>
    @foreach($bricks as $brick)
        <div data-brick-id="{{ $brick->id }}" data-brick-type="{{ $brick->brick_type }}" data-brick-version="{{ $brick->version ?? 1 }}">
            @includeIf("front.bricks.{$brick->brick_type}", ['brick' => $brick, 'content' => $brick->content ?? [], 'settings' => $brick->settings ?? []])
        </div>
    @endforeach

    <script>
        // Hot reload listener
        window.addEventListener('message', async function(event) {
            if (!event.data || event.data.type !== 'brick-updated') return;

            const brickId = event.data.brickId;
            if (!brickId) return;

            const target = document.querySelector(`[data-brick-id="${brickId}"]`);
            if (!target) return;

            try {
                const response = await fetch(`/admin/api/bricks/${brickId}/render`, {
                    headers: { 'Accept': 'application/json' },
                    credentials: 'same-origin'
                });
                if (!response.ok) return;
                const data = await response.json();

                target.innerHTML = data.html;
                target.setAttribute('data-brick-version', data.version);
                target.classList.add('brick-just-updated');
                setTimeout(() => target.classList.remove('brick-just-updated'), 1500);
            } catch (e) {
                console.warn('Hot reload failed for brick ' + brickId, e);
            }
        });

        // Bridge: when user clicks a brick in the preview, notify the parent editor
        document.querySelectorAll('[data-brick-id]').forEach(el => {
            el.addEventListener('click', function(e) {
                const brickId = parseInt(this.getAttribute('data-brick-id'), 10);
                if (window.parent !== window) {
                    window.parent.postMessage({ type: 'brick-clicked', brickId }, '*');
                }
            });
        });
    </script>
</body>
</html>
