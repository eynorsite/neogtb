## 2024-05-18 - [Cache Filament Dashboard Queries]
**Learning:** Admin dashboards often perform un-cached aggregate queries across multiple tables (e.g., counting unread messages, pending requests, total posts) on every load, creating a significant database bottleneck when many users load the dashboard or widgets poll frequently.
**Action:** When identifying aggregate metrics in Filament widgets (`StatsOverview`), wrap the queries in `Cache::remember` with short TTLs (e.g., 60 seconds) to avoid redundant overhead while keeping metrics acceptably fresh.
