## 2024-05-18 - Caching Filament Stats Overview Dashboard Queries
**Learning:** The Filament `StatsOverview` widget recalculates values based on database queries directly on every dashboard visit or refresh, leading to unnecessary DB load. Using Laravel's `Cache::remember` handles this gracefully with minimal code change.
**Action:** Always wrap standard administrative dashboard aggregated statistics inside a `Cache::remember` closure to improve application response times and reduce concurrent database query contention.
