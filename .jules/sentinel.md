## 2026-07-05 - [Optimize XSS Sanitization]
**Vulnerability:** Incomplete XSS protection using `strip_tags` and unsanitized user-generated content displayed directly in blades.
**Learning:** Even when adding XSS sanitization (like `stevebauman/purify`), calling it unconditionally on every string retrieval (like UI labels) can cause severe performance regressions.
**Prevention:** Implement a fast-path plain text check (`if ($value !== strip_tags($value))`) before calling expensive sanitizers like HTML Purifier to balance security with performance.
