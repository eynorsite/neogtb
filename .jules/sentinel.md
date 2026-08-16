## 2025-02-14 - Fix Stored XSS in Blade Variables
**Vulnerability:** Unsanitized user inputs originating from the database or filament configurations were being directly rendered using the `{!! $variable !!}` syntax. This can cause Stored XSS.
**Learning:** For application logic containing un-sanitized content being rendered via Blade variables, utilizing a fast-path plain text check approach limits the compute cost of the `Purify::clean()` rendering step while securing Stored XSS injection vectors.
**Prevention:** Always verify `{!! !!}` variables or blade blocks do not render user content directly; if required, sanitize via the fast-path wrapper or natively using the regular `{{ }}` syntax if raw HTML output is unnecessary.
