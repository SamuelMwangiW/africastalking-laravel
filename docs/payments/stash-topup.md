# Stash Top-Up

The Stash Top-Up API moves funds from your Africa's Talking payment wallet into your application's stash — a balance used to fund outbound SMS, airtime disbursements, and other services.

## Basic Example

```php
africastalking()
    ->stash()
    ->topup('KES', 5000);
```

## Fluent API

You can also build the request fluently and then call `topup()` or its alias `send()`:

```php
africastalking()
    ->stash()
    ->amount(10000)
    ->currency('KES')
    ->topup();
```

Override the product name from config on the fly:

```php
africastalking()
    ->stash()
    ->amount(10000)
    ->currency('USD')
    ->product('MyCustomProduct')  // overrides AFRICASTALKING_PAYMENT_PRODUCT in config
    ->send();
```

## Method Reference

| Method | Description |
|---|---|
| `amount(int\|float $amount)` | Amount to top up |
| `currency(string $code)` | ISO 4217 currency code (e.g. `KES`, `UGX`, `TZS`, `USD`) |
| `product(string $name)` | Override the payment product name from config |
| `topup()` | Dispatch the top-up request |
| `send()` | Alias for `topup()` |

## Example: Automated Balance Top-Up

Automatically top up when your stash balance runs low:

```php
<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;

class AutoTopup extends Command
{
    protected $signature = 'stash:topup {amount=5000}';

    public function handle(): void
    {
        $amount = (int) $this->argument('amount');

        africastalking()
            ->stash()
            ->amount($amount)
            ->currency('KES')
            ->send();

        $this->info("Stash topped up with KES {$amount}");
    }
}
```

::: warning
Funds are moved from your payment wallet. Ensure your wallet has sufficient balance before calling `topup()`. Check wallet balance with [`wallet()->balance()`](./wallet-balance).
:::
