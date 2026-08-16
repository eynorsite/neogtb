## 2024-06-29 - Cache Filament Stats Overview Queries
**Learning:** Expensive queries in Filament dashboard widgets execute on every page load, causing unnecessary database load.
**Action:** Use Laravel's `Cache::remember` with a short TTL (e.g., 60 seconds) to cache these statistics and improve dashboard load times.
