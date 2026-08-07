## 2026-06-15 - [Alpine.js Accordion Accessibility State]
**Learning:** When using Alpine.js `x-collapse` or `x-show` for accordions, the toggle button needs dynamic ARIA bindings (e.g., `:aria-expanded="open"` and `aria-controls="id"`) alongside focus states for full accessibility. Without these bindings, screen readers cannot properly announce the state of the component.
**Action:** Add proper `:aria-expanded` bindings and keyboard focus outlines to any newly created Alpine interactive components across the site.
