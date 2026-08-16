
## 2024-05-24 - FAQ Accordion Accessibility Patterns
**Learning:** When using Alpine.js for interactive accordion widgets (like the FAQ elements in Laravel Blade templates), native `<button>` tags require explicit `aria-expanded` attributes dynamically bound to the open state (e.g., `:aria-expanded="open.toString()"`), an `aria-controls` referencing the target panel's `id`, and proper keyboard focus indication (`focus-visible:ring-2` to ensure the tab focus is visibly distinct).
**Action:** Always ensure that interactive accordion components in Blade/Alpine.js setups contain `aria-controls`, dynamically bound `aria-expanded`, predictable unique `id`s on expandable regions, and explicit `focus-visible` outline treatments.
