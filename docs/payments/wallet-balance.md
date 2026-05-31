# Wallet Balance

Fetch the current balance of your Africa's Talking payment wallet. This is the funds available in your payment account — separate from your application account balance.

## Basic Usage

```php
$balance = africastalking()->wallet()->balance();

echo $balance->amount;   // "5000.0000"
echo $balance->currency; // "KES"
```

Or using the facade:

```php
use SamuelMwangiW\Africastalking\Facades\Africastalking;

/** @var \SamuelMwangiW\Africastalking\ValueObjects\Balance $balance */
$balance = Africastalking::wallet()->balance();
```

## The `Balance` Value Object

| Property | Type | Description |
|---|---|---|
| `amount` | `string` | Available wallet balance as a decimal string |
| `currency` | `string` | ISO 4217 currency code (e.g. `KES`, `UGX`) |

## Example: Low-Balance Alert

Check your wallet balance and send an internal alert if it drops below a threshold:

```php
<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use Illuminate\Support\Facades\Mail;

class CheckWalletBalance extends Command
{
    protected $signature = 'wallet:check';

    public function handle(): void
    {
        $balance = africastalking()->wallet()->balance();

        if ((float) $balance->amount < 1000) {
            Mail::to('finance@example.com')->send(
                new \App\Mail\LowWalletBalanceAlert($balance)
            );

            $this->warn("Low balance: {$balance->currency} {$balance->amount}");
        } else {
            $this->info("Wallet OK: {$balance->currency} {$balance->amount}");
        }
    }
}
```

::: tip Payment Wallet vs. Application Balance
- **Wallet balance** (`wallet()->balance()`) — funds in your payments account, used for Mobile Checkout, stash top-ups, etc.
- **Application balance** (`application()->balance()`) — credits in your Africa's Talking account, used for SMS, airtime, and voice.
:::
