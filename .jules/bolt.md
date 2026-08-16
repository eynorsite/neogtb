## 2025-06-21 - N+1 Query Issue in Related Models
**Learning:** When fetching collections of models in the controller (like `$related = Post::where(...)->get()`), if their related models are accessed in the Blade view loop (e.g. `$rel->category->name`), it causes an N+1 query problem. This is a common performance bottleneck in Laravel/Blade architecture.
**Action:** Always verify Blade templates to see which relationships of a collection are accessed during iteration. Eager load those relationships in the controller using `->with('relation')` before calling `->get()` or `->paginate()`.
