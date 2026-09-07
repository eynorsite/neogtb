## 2024-07-07 - Filament Dashboard Widget Optimization
**Learning:** Dashboard widgets in Filament run their aggregate queries (like `count()`) on every single load of the dashboard page. If there are multiple widgets, or large underlying tables, this becomes a noticeable bottleneck for admin users.
**Action:** Use Laravel's `Cache::remember` with a short TTL (like 60 seconds) within the `getStats()` method of widgets to prevent continuous duplicate database queries on highly-accessed dashboard pages.
