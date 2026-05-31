# Mobile Checkout

Mobile Checkout initiates a payment prompt on a customer's phone (e.g. an M-Pesa STK push). The customer receives a PIN prompt and approves the payment directly from their handset — no card details or web redirects needed.

## Basic Example

```php
africastalking()
    ->payment()
    ->mobileCheckout()
    ->to('+254720123123')
    ->amount(500)
    ->currency('KES')
    ->send();
```

Or using the facade:

```php
use SamuelMwangiW\Africastalking\Facades\Africastalking;

Africastalking::payment()
    ->mobileCheckout()
    ->to('+254720123123')
    ->amount(500)
    ->currency('KES')
    ->send();
```

## Method Reference

| Method | Description |
|---|---|
| `to(string $phone)` | Recipient phone number in international format |
| `amount(int\|float $amount)` | Amount to charge |
| `currency(string $code)` | ISO 4217 currency code (e.g. `KES`, `UGX`, `TZS`) |
| `send()` | Dispatch the payment request |

## Example: E-Commerce Checkout

```php
<?php

namespace App\Http\Controllers\Payments;

use App\Models\Order;
use Illuminate\Http\Request;

class CheckoutController
{
    public function pay(Request $request, Order $order)
    {
        $request->validate([
            'phone' => 'required|string',
        ]);

        africastalking()
            ->payment()
            ->mobileCheckout()
            ->to($request->phone)
            ->amount($order->total)
            ->currency('KES')
            ->send();

        return response()->json([
            'message' => 'Payment prompt sent. Please approve on your phone.',
        ]);
    }
}
```

## Handling the Payment Callback

Africa's Talking sends a POST notification to your callback URL once the customer approves or declines the payment. Use the `PaymentNotificationRequest` to handle it:

```php
// routes/api.php
Route::post('/callbacks/payment', [PaymentCallbackController::class, '__invoke']);
```

```php
<?php

namespace App\Http\Controllers\Payments;

use App\Models\Order;
use SamuelMwangiW\Africastalking\Http\Requests\PaymentNotificationRequest;

class PaymentCallbackController
{
    public function __invoke(PaymentNotificationRequest $request)
    {
        Order::query()
            ->where('transaction_id', $request->id())
            ->update(['status' => $request->status()]);

        return response('OK');
    }
}
```

::: tip Sandbox Testing
In the sandbox, use the [Simulator](https://simulator.africastalking.com/) on the Africa's Talking dashboard to approve test payments without real money.
:::
