<?php

namespace App\Http\Controllers;

use App\Models\PageBrick;
use App\Models\SitePage;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;

/**
 * Renders bricks in isolation for the brick editor live preview iframe.
 * Used by the Filament BrickEditorPage to provide real-time visual feedback.
 *
 * Routes:
 *   GET /admin/api/bricks/preview/{pageId}     -> full page rendered with all visible bricks
 *   GET /admin/api/bricks/{brickId}/render     -> single brick HTML for hot reload
 */
class BrickPreviewController extends Controller
{
    public function previewPage(int $pageId)
    {
        // Authorization: only authenticated admins (any role)
        $admin = auth()->guard('admin')->user();
        if (!$admin) {
            abort(401, 'Unauthorized');
        }

        $page = SitePage::with(['bricks' => function ($q) {
            $q->orderBy('order');
        }])->findOrFail($pageId);

        return response()
            ->view('admin.brick-preview', [
                'page' => $page,
                'bricks' => $page->bricks->where('is_visible', true)->values(),
                'previewMode' => true,
            ])
            ->header('X-Frame-Options', 'SAMEORIGIN')
            ->header('Cache-Control', 'no-store, no-cache, must-revalidate');
    }

    public function renderBrick(int $brickId): JsonResponse
    {
        $admin = auth()->guard('admin')->user();
        if (!$admin) {
            return response()->json(['error' => 'Unauthorized'], 401);
        }

        $brick = PageBrick::find($brickId);
        if (!$brick) {
            return response()->json(['error' => 'Brick not found'], 404);
        }

        try {
            $html = view("front.bricks.{$brick->brick_type}", [
                'brick' => $brick,
                'content' => $brick->content ?? [],
                'settings' => $brick->settings ?? [],
            ])->render();

            return response()->json([
                'brickId' => $brick->id,
                'version' => $brick->version ?? 1,
                'html' => $html,
            ]);
        } catch (\Throwable $e) {
            return response()->json([
                'error' => 'Render failed',
                'message' => $e->getMessage(),
            ], 500);
        }
    }
}
