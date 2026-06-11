## 2024-06-11 - Resolving N+1 query bottlenecks in Blog views
**Learning:** Blade templates iterating over relationships like `$post->tags` or `$rel->category` trigger lazy-loaded N+1 database queries when those relationships are omitted from `with()` eager-loading in the controller.
**Action:** Always check the Blade template associated with a controller method to see which relationships are accessed, and explicitly include them via `->with(['rel1', 'rel2'])` in the query builder to prevent N+1 issues.
