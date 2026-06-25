## 2024-06-25 - [Fix N+1 query problems in PageController]
**Learning:** Found N+1 queries in `PageController` rendering `category` and `tags` relations on collections of `Post` objects due to a lack of proper eager loading in `with()`.
**Action:** Always verify if relations used in view loops (e.g., tags, category) are eager-loaded in the Controller via Eloquent `with()`.
