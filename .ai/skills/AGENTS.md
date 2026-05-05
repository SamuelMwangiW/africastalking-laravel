# CLAUDE.md

This file provides guidance to Claude Code (claude.ai/code) when working with code in this repository.

## About

`africastalking-laravel` is an unofficial Laravel SDK (packaged as a Composer library) for Africa's Talking APIs. It uses [Saloon](https://docs.saloon.dev/) for HTTP requests and [spatie/laravel-package-tools](https://github.com/spatie/laravel-package-tools) for the service provider scaffolding. It supports PHP 8.3+ and Laravel 12+.

## Commands

```bash
# Run all tests
composer test

# Run a single test file
vendor/bin/pest tests/AirtimeTest.php

# Run a single test by name
vendor/bin/pest --filter "test name"

# Run static analysis
composer analyse

# Format code
vendor/bin/pint
```

## Architecture

### Entry Points

- **`Africastalking` class** (`src/Africastalking.php`) — The main facade root. Each method (`airtime()`, `sms()`, `voice()`, etc.) returns a domain object resolved from the container.
- **`africastalking()` helper** (`src/helpers.php`) — Global helper that returns the facade root.
- **`AfricastalkingServiceProvider`** (`src/AfricastalkingServiceProvider.php`) — Registers the `AfricastalkingConnector` as a singleton and publishes the config.

### Request Flow

Domain objects (in `src/Domain/`) build up state (e.g. recipients, body text) and then call `->send()`, which delegates to a **Saloon Request** (`src/Saloon/Requests/`). All requests go through `AfricastalkingConnector` (`src/Saloon/AfricastalkingConnector.php`), which resolves the correct base URL by checking if `config('africastalking.username') === 'sandbox'`.

The `Service` enum (`src/Enum/Service.php`) maps each API domain to both live and sandbox base URLs — this is the single source of truth for endpoint routing.

### Faking / Testing

`Africastalking::fake()` swaps domain implementations with test fakes (in `src/Testing/Fakes/`). After calling `fake()`, the facade exposes assertion methods like `assertSmsSent()`, `assertAirtimeSent()`, `assertVoiceCallSent()`.

Tests use Pest and are in `tests/`. Fixtures for HTTP responses live in `tests/Fixtures/`. Datasets (reusable Pest data providers) are in `tests/Datasets/`.

### Code Style

- All PHP files must have `declare(strict_types=1)`.
- Code style enforced by Pint with the `per` preset (see `pint.json`). Notable rules: `yoda_style`, `use_arrow_functions`, `ordered_imports` (alpha, const/class/function order), `declare_strict_types`.
- PHPStan runs at level 8 with larastan extensions (see `phpstan.neon.dist`).

### Config

Published config key is `africastalking`. Relevant env vars:
- `AFRICASTALKING_USERNAME` (defaults to `sandbox`)
- `AFRICASTALKING_API_KEY`
- `AFRICASTALKING_FROM` — SMS sender ID
- `AFRICASTALKING_PAYMENT_PRODUCT`
- `AFRICASTALKING_VOICE_PHONE_NUMBER`
