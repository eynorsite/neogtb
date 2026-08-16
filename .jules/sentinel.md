## 2025-02-18 - XSS in Dynamic Blade Content
**Vulnerability:** The FAQ page rendered dynamic content from the database (`faq_page_config` managed by admins) directly using the `{!! !!}` unescaped Blade syntax. This could allow for Stored XSS if a compromised admin account or a vulnerability in the Filament panel allowed malicious script injection.
**Learning:** Even content originating from a trusted back-office needs strict sanitization before being rendered using unescaped syntax.
**Prevention:** Always use `\Stevebauman\Purify\Facades\Purify::clean($content)` around dynamic HTML content rendered with `{!! !!}` in Blade templates, especially when the content originates from the database and allows HTML.
