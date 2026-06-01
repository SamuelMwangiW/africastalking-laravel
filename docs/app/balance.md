# Application Balance

Fetch the current balance of your Africa's Talking application account.

## Basic Usage

```php
use SamuelMwangiW\Africastalking\Facades\Africastalking;

$balance = Africastalking::application()->balance();

echo $balance->amount;          // 100.5
echo $balance->currency->value; // "KES"
```

You can also use the global helper function:

```php
$balance = africastalking()->application()->balance();
```

## The `Balance` Value Object

The response is an instance of `\SamuelMwangiW\Africastalking\ValueObjects\Balance` with the following properties:

| Property | Type | Description |
|---|---|---|
| `amount` | `float` | Account balance |
| `currency` | `Currency` | Backed enum — use `->value` to get the ISO 4217 code string (e.g. `KES`, `UGX`) |

## Example: Display Balance in a Controller

```php
<?php

namespace App\Http\Controllers;

use SamuelMwangiW\Africastalking\Facades\Africastalking;

class DashboardController
{
    public function index()
    {
        $balance = Africastalking::application()->balance();

        return view('dashboard', [
            'balance'  => $balance->amount,
            'currency' => $balance->currency->value,
        ]);
    }
}
```

::: tip
In the sandbox environment the balance will reflect the credits assigned to your sandbox account at [sandbox.africastalking.com](https://sandbox.africastalking.com/).
:::
