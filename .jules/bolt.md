## 2024-07-06 - [HTML Sanitization Fast-Path]
**Learning:** Purify::clean() is computationally expensive. When sanitizing user-managed content that is often just plain text, we can avoid the overhead of calling Purify::clean() by first checking if the string contains HTML using a simple string comparison like `$value !== strip_tags($value)`. This reduces the sanitization time significantly for plain text.
**Action:** Implement a fast-path plain text check before calling Purify::clean() in blade templates to improve rendering performance.
