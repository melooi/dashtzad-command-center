# MVP Scope — Phase Zero

## What Phase Zero Includes

- Repository structure and clean `.gitignore`
- Documentation files: `README.md`, `ROADMAP.md`, `SECURITY.md`, `docs/setup.md`, `docs/architecture.md`, `docs/mvp-scope.md`
- Exact local setup commands for Mac, VPS, and GitHub Codespaces
- Architecture overview and phase roadmap
- Security policy baseline

## What Phase Zero Excludes

Phase Zero is **documentation and planning only**. Nothing below exists in this repository yet.

### Framework

- No Laravel installation — `composer.json`, `artisan`, `app/`, `bootstrap/`, `config/`, `routes/`, `vendor/` do not exist.
- No Filament installation — no panel scaffold, no resources, no pages, no widgets.
- No fake or manually written Laravel/Filament files as substitutes.

### Integrations

- No SMS integration (no provider, no OTP logic, no queue jobs for messaging)
- No Telegram bot or Bale messenger integration
- No WooCommerce connection or product sync
- No OpenAI or Claude AI integration
- No AI Manager or agent orchestration logic

### Business Logic

- No product price change workflows
- No product publish or delete workflows
- No bulk messaging or campaign dispatch
- No coupon generation logic
- No approval gateway implementation

## Why

Laravel and Filament must be installed via Composer with Packagist access. The current CI/cloud environment blocks outbound traffic to `packagist.org`. Installation will be performed on a local Mac, VPS, or GitHub Codespaces where Packagist is reachable. See [docs/setup.md](setup.md) for exact commands.

Once the framework is installed, Phase One begins: Filament panel scaffold, first resource, role/permission setup.
