## 2025-02-23 - Avoid unverified facades

**Vulnerability:** A previous patch used a third-party facade (`\Stevebauman\Purify\Facades\Purify`) without verifying its existence, which could lead to a fatal error if the package is missing.
**Learning:** Always verify that a third-party dependency (e.g., `stevebauman/purify`) is explicitly required in `composer.json` before using it in the code.
**Prevention:** I checked `composer.json` using `grep -i purify` and confirmed `stevebauman/purify` is explicitly listed under `"require"`, making its usage safe.
