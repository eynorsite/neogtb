## 2026-06-08 - Fixed N+1 queries in blog controllers
**Learning:** Blade templates often access relationships (like `tags` on `Post` in blog lists, or `category` on related posts) that aren't eager loaded in the controller, causing silent N+1 query performance bottlenecks.
**Action:** Always check Blade views for relationship access (e.g., `$post->tags`, `$post->author`, `$related->category`) and ensure those relationships are included in the controller's `with()` clause when fetching collections or even single models.
