## 2025-07-04 - Stored XSS in Filament Blocks
**Vulnerability:** Raw HTML from user-managed Filament data was being rendered directly in blade templates (e.g., FAQ answers, legal pages, rich text bricks) using the {!! $content !!} syntax.
**Learning:** In a CMS like Filament, data entered via WYSIWYG editors or rich text fields is stored as HTML. Directly outputting this via {!! !!} allows any admin user (or compromised admin account) to execute arbitrary JavaScript on the frontend.
**Prevention:** Always sanitize HTML content sourced from a database or CMS before rendering it. Use `\Stevebauman\Purify\Facades\Purify::clean($content)` within the {!! !!} tags to safely parse and filter out malicious scripts while preserving formatting.
