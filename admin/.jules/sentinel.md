## 2025-03-09 - [Fix XSS vulnerability in FAQ answers and rich text components]
**Vulnerability:** Unsanitized user input from Filament admin components (FAQ answers and Rich Text builder components) was directly rendered using Laravel Blade's `{!! ... !!}` unescaped syntax.
**Learning:** Even though Blade escapes by default using `{{ ... }}`, some components like Rich Text require rendering HTML, and thus use `{!! ... !!}`. When the content originates from an administrative CMS input (like Filament), a malicious administrator can inject persistent XSS vulnerabilities into the site.
**Prevention:** Always wrap dynamically generated HTML strings from CMS inputs with `\Stevebauman\Purify\Facades\Purify::clean(...)` before rendering them with `{!! ... !!}` in the blade views.
