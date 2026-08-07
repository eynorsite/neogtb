
## 2024-11-20 - [N+1 Queries in Blade Templates]
**Learning:** Found N+1 queries in the blog and article views caused by accessing relationships (`tags` on posts, and `category` on related posts) that were not eager loaded in the controller.
**Action:** When rendering lists of models in Blade views, always check which relationships are accessed inside the loop and ensure they are eager loaded in the controller using `->with(['relation1', 'relation2'])`.
