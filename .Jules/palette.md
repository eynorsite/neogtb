## 2025-06-05 - Missing ARIA labels on modals
**Learning:** Found an icon-only `closeModal()` button in `admin/resources/views/front/tables-modbus.blade.php` that was missing an `aria-label`. This pattern of using an SVG inside an empty button for modals is common and needs explicit labeling for screen readers.
**Action:** Always ensure modal close buttons or any interactive element that relies solely on an SVG icon includes a descriptive `aria-label` (e.g. `aria-label="Fermer"` in French contexts).
