## 2026-06-17 - [Footer Form A11y & Feedback]
**Learning:** Adding `aria-live="polite"` directly to dynamically rendered error and success message containers (via Alpine `x-show`) is an effective and safe pattern to improve screen reader accessibility for async forms in this repository.
**Action:** Always include `aria-live="polite"` on client-side form validation message containers across all layouts.
