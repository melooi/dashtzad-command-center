# Security Policy

## Secrets and Credentials

- No API keys, tokens, or secrets in frontend code — ever.
- All secrets must be stored server-side only, in `.env` files or a secrets manager.
- `.env` is `.gitignore`d and must never be committed to the repository.
- Secrets must be encrypted at rest using Laravel's encryption facilities or an equivalent server-side mechanism.

## Approval Gateway

Sensitive actions require an Approval Gateway before execution. No sensitive action may be performed without explicit user confirmation and permission validation.

**Sensitive actions include (non-exhaustive):**

- Price changes on any product
- Product publish or delete
- Bulk SMS dispatch
- Coupon creation or modification
- API key creation, rotation, or deletion
- Security setting changes
- Role or permission changes

## OTP / SMS Verification

- SMS OTP codes must be stored as **hashed values only** — raw OTP codes must never be persisted.
- OTP records must include:
  - Expiration timestamp
  - Maximum attempt counter (lock after N failures)
  - Resend rate limit (per user, per IP)
  - IP address and user-agent logged at issuance and verification

## Audit Logging

All important actions must be audit logged with at minimum:

- Actor (user ID, role)
- Action performed
- Target resource
- Timestamp
- IP address

Audit logs must not be deletable by regular users or admins. Only system-level rotation is permitted.

## Authorization

- User roles and permissions must be verified server-side before any tool action is executed.
- Frontend permission checks are UI sugar only — they do not replace backend enforcement.
- Filament resource access policies must be defined for every resource that handles sensitive data.
