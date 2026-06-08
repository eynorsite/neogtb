## 2024-05-18 - Newsletter Async Submit Feedback
**Learning:** For asynchronous form submissions (like newsletter signups in footers), simply changing button text to "..." is insufficient. Users need clear visual feedback (like a spinner) and structural hints (like `opacity-70` and `cursor-not-allowed`) to prevent confusion and multiple click attempts.
**Action:** Always include both an SVG loading spinner and explicit disabled visual states for any async submit button.
