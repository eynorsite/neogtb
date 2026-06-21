## 2026-06-21 - Focus-Visible Utility Usage in Alpine.js Chatbot
**Learning:** Alpine.js conditionally rendered elements (like chatbots or modals) frequently miss standardized focus indicators when using custom border/ring styles.
**Action:** Always ensure interactive elements within newly opened components include robust `focus-visible:ring-2` styling, rather than relying solely on hover states, to support keyboard navigation.
