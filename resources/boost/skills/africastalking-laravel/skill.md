---
name: africastalking-laravel
description: Integrate Africa's Talking APIs (SMS, Voice, Airtime, Payments, USSD) into a Laravel application using the samuelmwangiw/africastalking-laravel package. Use this skill when the user asks to send SMS, make voice calls, disburse airtime, initiate mobile payments, or handle USSD sessions via Africa's Talking.
---

This skill integrates the `samuelmwangiw/africastalking-laravel` package into an existing Laravel application. The package wraps Africa's Talking APIs using Laravel's native HTTP client, service container, and notification system via the Saloon HTTP library.

The user will describe what Africa's Talking feature they want to use. Implement it correctly using the patterns below — do not deviate from the fluent API signatures, they are exact.

## Installation

```bash
composer require samuelmwangiw/africastalking-laravel
php artisan vendor:publish --tag="africastalking-config"
```

Add to `.env`:
```env
AFRICASTALKING_USERNAME=sandbox          # use 'sandbox' for development, your AT username for production
AFRICASTALKING_API_KEY=your-api-key
AFRICASTALKING_FROM=YourSenderID        # SMS sender ID or short code
AFRICASTALKING_PAYMENT_PRODUCT=MyApp   # Payment product name (required for payments/data bundles)
AFRICASTALKING_VOICE_PHONE_NUMBER=+254700000000  # Caller ID for outbound calls
```

The package auto-discovers its service provider. When `AFRICASTALKING_USERNAME=sandbox`, all requests are routed to Africa's Talking sandbox URLs automatically — no other changes needed.

## Two equivalent usage styles

Both are always valid. Prefer the facade for controller/service code and the helper for quick one-liners.

```php
use SamuelMwangiW\Africastalking\Facades\Africastalking;

Africastalking::sms('Hello!')->to('+254712345678')->send();
africastalking()->sms('Hello!')->to('+254712345678')->send(); // helper equivalent
```

## SMS

### Bulk SMS (default)
```php
use SamuelMwangiW\Africastalking\Facades\Africastalking;

$response = Africastalking::sms('Your OTP is 123456')
    ->to('+254712345678')                    // single recipient (string)
    ->send();

// Multiple recipients
$response = Africastalking::sms('Flash sale ends in 1 hour!')
    ->to(['+254712345678', '+256706123567']) // array of E.164 numbers
    ->as('MyBIZ')                            // optional: override sender ID
    ->enqueue()                              // optional: enqueue for delivery assurance
    ->send();
```

### Premium SMS
```php
$response = Africastalking::sms('Your subscription is confirmed')
    ->to(['+254712345678'])
    ->as('90012')          // short code
    ->premium()            // marks as premium
    ->keyword('CONFIRM')   // optional
    ->linkId('abc-123')    // optional: for subscription flows
    ->retry(2)             // retry for 2 hours if undelivered
    ->send();
```

`send()` returns a `SentMessageResponse`. Recipients that failed have a non-"Success" status code.

## Laravel Notifications (SMS Channel)

Use this when integrating with Laravel's notification system.

**Notification class:**
```php
<?php

namespace App\Notifications;

use Illuminate\Notifications\Notification;
use SamuelMwangiW\Africastalking\Notifications\AfricastalkingChannel;

class OrderShipped extends Notification
{
    public function via($notifiable): array
    {
        return [AfricastalkingChannel::class];
    }

    // Return a string for a simple message routed to the notifiable's phone.
    // Return a Message object for full control over sender ID, bulk mode, etc.
    public function toAfricastalking($notifiable): string
    {
        return "Hi {$notifiable->name}, your order has shipped!";
    }
}
```

**Notifiable model** — must implement `ReceivesSmsMessages`:
```php
<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Notifications\Notifiable;
use Illuminate\Notifications\Notification;
use SamuelMwangiW\Africastalking\Contracts\ReceivesSmsMessages;

class User extends Model implements ReceivesSmsMessages
{
    use Notifiable;

    public function routeNotificationForAfricastalking(Notification $notification): string
    {
        return $this->phone; // E.164 format, e.g. '+254712345678'
    }
}
```

## Voice

```php
// Basic outbound call
africastalking()->voice()->call('+254720123123')->done();

// Call multiple numbers
africastalking()->voice()->call(['+254720123123', '+254731234567'])->done();

// Override caller ID (must be a verified AT number)
africastalking()->voice()
    ->call('+254720123123')
    ->as('+254711082999')
    ->done();

// With client request ID for deduplication
africastalking()->voice()
    ->call('+254720123123')
    ->requestId('order-456-call')
    ->done(); // ->send() is an alias
```

`done()` / `send()` returns `VoiceCallResponse`.

## Airtime

```php
use SamuelMwangiW\Africastalking\Facades\Africastalking;

// Single recipient
$response = Africastalking::airtime()
    ->to('+254712345678', 'KES', 100) // phone, currency code, amount in smallest unit
    ->send();

// Multiple recipients — chain to() or add() calls
$response = africastalking()->airtime()
    ->to('+254712345678', 'KES', 50)
    ->add('+256706345678', 'UGX', 500)
    ->send();

// Batch from a query
$airtime = africastalking()->airtime();
User::query()->chunk(500, function ($users) use ($airtime) {
    foreach ($users as $user) {
        $airtime->add($user->phone, 'KES', 20);
    }
});
$results = $airtime->send();
```

Currency codes: `KES`, `UGX`, `TZS`, `NGN`, `GHS`, `ETB`, `ZMW`, `TZS`, etc. — must match the `Currency` enum values.

## Payments

### Mobile Checkout (STK Push)
```php
africastalking()->payment()
    ->mobileCheckout()
    ->to('+254720123123')
    ->amount(5000)
    ->currency('KES')              // optional, defaults to KES
    ->metadata(['orderId' => 42])  // optional key-value pairs
    ->send();
```

### Wallet Balance
```php
$balance = africastalking()->wallet()->balance();
// $balance->currency->value  e.g. 'KES'
// $balance->amount           e.g. 1500.00
```

### Stash Top-up (move funds from wallet to payment stash)
```php
africastalking()->stash()
    ->amount(1000)
    ->currency('KES')
    ->send();
```

## Data Bundles (Mobile Data)

```php
use SamuelMwangiW\Africastalking\Enum\BundlesValidity;
use SamuelMwangiW\Africastalking\Enum\BundlesUnit;

africastalking()->mobileData()
    ->to('+254712345678', quantity: 100, validity: BundlesValidity::DAY, unit: BundlesUnit::MB)
    ->send();
```

`africastalking()->bundles()` is an alias for `mobileData()`.

## USSD

Return `africastalking()->ussd()` directly from a controller — it implements `Responsable` and sets `Content-Type: text/plain` with the required `CON`/`END` prefix automatically.

```php
<?php

namespace App\Http\Controllers;

use SamuelMwangiW\Africastalking\Http\Requests\UssdSessionRequest;

class UssdController extends Controller
{
    public function session(UssdSessionRequest $request)
    {
        // No input yet — prompt the user
        if (! $request->userInput()) {
            return africastalking()->ussd('Enter your account number:');
            // Renders: "CON Enter your account number:"
        }

        $input = $request->userInput(); // full USSD string, e.g. "1*2"

        // End the session
        return africastalking()->ussd("Your balance is KES 500")->end();
        // Renders: "END Your balance is KES 500"
    }
}
```

Register the route in `routes/web.php` (AT posts to this endpoint):
```php
Route::post('/ussd/session', [UssdController::class, 'session']);
```

## SIM Swap / Insights

```php
$result = africastalking()->simSwap()
    ->for('+254712345678')
    ->send();

// africastalking()->insights() is an alias for simSwap()
```

## Idempotency

`Airtime`, `MobileCheckout`, `MobileData`, and `SimSwap` support idempotency keys to prevent duplicate requests:

```php
Africastalking::airtime()
    ->idempotent('unique-key-per-request')
    ->to('+254712345678', 'KES', 100)
    ->send();
```

## Testing

Call `Africastalking::fake()` in a test to prevent real HTTP calls. Fakes are available for SMS, Airtime, and Voice.

```php
use SamuelMwangiW\Africastalking\Facades\Africastalking;

it('sends an SMS on order creation', function () {
    Africastalking::fake();

    // ... trigger the code under test ...

    Africastalking::assertSmsSent();
    Africastalking::assertAirtimeSent();
    Africastalking::assertVoiceCallSent();

    // Negative assertions
    Africastalking::assertNoSmsSent();
    Africastalking::assertNoAirtimeSent();
    Africastalking::assertNoVoiceCallSent();
});
```

`fake()` replaces `Message`, `Airtime`, and `VoiceCall` container bindings with in-memory fakes for the duration of that test only — state does not leak between tests.

## Key constraints to follow

- Phone numbers must be in **E.164 format** (e.g. `+254712345678`). The `PhoneNumber::make()` value object validates this internally.
- `WebRTC` is **not available on sandbox** — it throws an exception. Do not use it in sandbox/dev environments.
- `config('africastalking.username') === 'sandbox'` (case-insensitive) is what switches all URLs to sandbox. Do not hardcode URLs.
- `send()` throws on HTTP errors via Saloon's `.throw()` — wrap calls in try/catch in production code when appropriate.
- The `payment.product-name` config value is required for Payments, MobileData, and Stash — ensure `AFRICASTALKING_PAYMENT_PRODUCT` is set before calling those APIs.
