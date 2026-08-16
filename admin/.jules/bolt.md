## 2026-06-06 - Eager loading relationships accessed in blade templates

**Learning:** When adding relationships to `with()` in Laravel controllers, check exactly which attributes are accessed in the Blade views. The `tags` relationship was being lazy-loaded on every loop iteration inside `blog.blade.php`, leading to N+1 queries. We fixed this by eager loading `tags` in `PageController@blog`.
**Action:** Always search the Blade views for the relationships used (e.g. `->tags`, `->category`) when optimizing the queries that provide data to them.
