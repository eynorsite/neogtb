## 2026-06-13 - [Fixed N+1 queries when loading tags for blog posts]
**Learning:** The blog posts page renders tags for each post (`$post->tags` in a loop). Previously, only the `category` relationship was eager loaded, which resulted in N+1 database queries to fetch the tags for each of the listed posts.
**Action:** Always eager load both `category` and `tags` using `->with(['category', 'tags'])` when fetching multiple posts for listing pages, particularly in `PageController@blog`, to prevent performance bottlenecks.
