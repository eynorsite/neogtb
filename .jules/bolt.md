## 2025-01-20 - N+1 query in blog page tags rendering
**Learning:** Found an N+1 query on the blog page since it was loading `$post->tags` during rendering without eager loading it in the controller (`with('tags')`).
**Action:** Always verify loops that render relationships in Blade templates to ensure they are eager loaded in the corresponding controller.