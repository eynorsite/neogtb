<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Cache;
use Illuminate\Database\Eloquent\Casts\Attribute;

class SiteSetting extends Model
{
    protected $fillable = [
        'group', 'key', 'value', 'type', 'label', 'description',
        'is_public', 'is_encrypted', 'is_required', 'order',
    ];

    protected function casts(): array
    {
        return [
            'is_public' => 'boolean',
            'is_encrypted' => 'boolean',
            'is_required' => 'boolean',
        ];
    }

    /**
     * Auto encrypt/decrypt value when is_encrypted is true.
     */
    protected function value(): Attribute
    {
        return Attribute::make(
            get: function ($value) {
                if ($this->is_encrypted && filled($value)) {
                    try {
                        return decrypt($value);
                    } catch (\Exception $e) {
                        return $value; // graceful fallback
                    }
                }

                return $value;
            },
            set: function ($value) {
                if ($this->is_encrypted && filled($value)) {
                    return encrypt($value);
                }

                return $value;
            },
        );
    }

    // --- Static helpers ---

    public static function get(string $key, mixed $default = null): mixed
    {
        return Cache::remember("site_setting.{$key}", 300, function () use ($key, $default) {
            $setting = static::where('key', $key)->first();

            return $setting?->value ?? $default;
        });
    }

    public static function set(string $key, mixed $value): void
    {
        $setting = static::where('key', $key)->first();

        if ($setting) {
            $setting->value = $value;
            $setting->save();
        }

        Cache::forget("site_setting.{$key}");
    }

    public static function getGroup(string $group): array
    {
        return Cache::remember("site_settings_group.{$group}", 300, function () use ($group) {
            return static::where('group', $group)
                ->orderBy('order')
                ->get()
                ->mapWithKeys(fn ($s) => [$s->key => $s->value])
                ->toArray();
        });
    }

    public static function getAllCached(): array
    {
        return Cache::remember('site_settings_all', 300, function () {
            return static::where('is_public', true)
                ->get()
                ->mapWithKeys(fn ($s) => [$s->key => $s->value])
                ->toArray();
        });
    }

    public static function clearCache(): void
    {
        $keys = static::pluck('key');

        foreach ($keys as $key) {
            Cache::forget("site_setting.{$key}");
        }

        $groups = static::distinct()->pluck('group');

        foreach ($groups as $group) {
            Cache::forget("site_settings_group.{$group}");
        }

        Cache::forget('site_settings_all');
    }

    protected static function booted(): void
    {
        static::saved(fn () => static::clearCache());
        static::deleted(fn () => static::clearCache());
    }
}
