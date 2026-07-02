## 2025-07-02 - Ensure Alpine.js accordions are fully accessible
**Learning:** Found a pattern in this application where Alpine.js accordions (`x-data="{ open: null }"`) were missing essential ARIA attributes (`aria-expanded`, `aria-controls`) and proper focus rings for keyboard accessibility.
**Action:** Always verify that Alpine.js interactive components have dynamic ARIA attributes linked to their state, and standardize focus indicators with `focus:outline-none focus-visible:ring-2 focus-visible:ring-primary-500` (or similar depending on the component context).
