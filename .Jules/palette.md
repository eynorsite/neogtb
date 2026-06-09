## 2026-06-09 - Alpine.js Accordion Accessibility
**Learning:** Alpine.js accordions (like the FAQ) require dynamically bound `aria-expanded` attributes (`x-bind:aria-expanded="open.toString()"`) to properly notify screen readers of state changes, along with proper `aria-controls` and focus styling for keyboard users.
**Action:** Always ensure interactive elements controlled by Alpine.js have synchronized ARIA attributes and visible focus states (`focus-visible:ring-2`).
