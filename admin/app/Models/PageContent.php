<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Cache;

class PageContent extends Model
{
    protected $fillable = ['page', 'section', 'key', 'value', 'type', 'label'];

    // --- Scopes ---
    public function scopeForPage($query, string $page)
    {
        return $query->where('page', $page);
    }

    public function scopeForSection($query, string $page, string $section)
    {
        return $query->where('page', $page)->where('section', $section);
    }

    // --- Lecture avec cache ---
    public static function getValue(string $page, string $section, string $key, mixed $default = null): mixed
    {
        $data = static::getPageData($page);
        return $data[$section][$key] ?? $default;
    }

    public static function getPageData(string $page): array
    {
        return Cache::remember("page_contents_{$page}", 3600, function () use ($page) {
            return static::where('page', $page)
                ->get()
                ->groupBy('section')
                ->map(fn ($items) => $items->pluck('value', 'key')->toArray())
                ->toArray();
        });
    }

    public static function clearCache(?string $page = null): void
    {
        if ($page) {
            Cache::forget("page_contents_{$page}");
        } else {
            $pages = static::select('page')->distinct()->pluck('page');
            foreach ($pages as $p) {
                Cache::forget("page_contents_{$p}");
            }
        }
    }
}
