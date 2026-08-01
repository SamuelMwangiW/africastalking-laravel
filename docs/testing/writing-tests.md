# Testing

Feature and unit tests that exercise code calling this package would otherwise hit the real Africa's Talking sandbox API — slow, network-dependent, and liable to fail in CI. The companion package [`samuelmwangiw/africastalking-laravel-tests`](https://github.com/samuelmwangiw/africastalking-laravel-tests) fakes every request at the HTTP layer and gives you expressive assertions instead.

## Installation

Install it as a dev dependency — it should never ship in production:

```bash
composer require samuelmwangiw/africastalking-laravel-tests --dev
```

The package auto-registers its service provider via Laravel package discovery. No further setup is required.

## Basic Usage

Call `Africastalking::fake()` at the start of a test to intercept every request the main package would otherwise send. Your application code runs completely unmodified — it has no idea it isn't talking to the real API:

```php
use SamuelMwangiW\Africastalking\Facades\Africastalking;

it('sends a welcome sms', function () {
    Africastalking::fake();

    Africastalking::sms('Welcome!')->to('+254700000000')->send();

    Africastalking::assertSmsSentTo('+254700000000');
});
```

Once `Africastalking::fake()` has been called, assertions (`assert*`) and read-only helpers (`recorded()`) can be called directly on the facade, as shown above. Methods that change fake behaviour (`fail*`, `with*`, `fakeWalletBalance`) must go through `Africastalking::fake()->...` — this keeps it visually obvious in a test which calls are configuring the fake and which are asserting on it.

## Testing Controller Code

Since the fake intercepts requests at the HTTP layer, it works exactly the same whether `Africastalking::sms()` is called directly, from a queued job, or from deep inside a controller action. Given a controller that sends an OTP:

```php
<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\RedirectResponse;
use SamuelMwangiW\Africastalking\Facades\Africastalking;

class SendOtpController extends Controller
{
    public function __invoke(User $user): RedirectResponse
    {
        $otp = random_int(100000, 999999);

        cache()->put("otp:{$user->id}", $otp, now()->addMinutes(5));

        Africastalking::sms("Your verification code is {$otp}")
            ->to($user->phone)
            ->send();

        return back()->with('status', 'OTP sent.');
    }
}
```

A feature test can hit the route as normal and assert on the SMS that was sent, without ever touching the network:

```php
use App\Models\User;
use SamuelMwangiW\Africastalking\Facades\Africastalking;

it('sends an otp when the route is hit', function () {
    Africastalking::fake();

    $user = User::factory()->create(['phone' => '+254712345678']);

    $this->post(route('otp.send', $user))
        ->assertRedirect();

    Africastalking::assertSmsSentTo('+254712345678');
    Africastalking::assertSmsCount(1);
});
```

To assert on the message content itself — useful here, since the OTP is randomly generated and stored in cache — read it back out and assert against it:

```php
it('sends the same otp that was cached', function () {
    Africastalking::fake();

    $user = User::factory()->create(['phone' => '+254712345678']);

    $this->post(route('otp.send', $user));

    $otp = cache()->get("otp:{$user->id}");

    Africastalking::assertSmsContains((string) $otp);
});
```

## Simulating Failures

Use `fail*()` methods to make the fake reject requests, so you can test your application's error handling without waiting for a real failure:

```php
it('handles a failed sms gracefully', function () {
    Africastalking::fake()->failSms();

    $user = User::factory()->create(['phone' => '+254712345678']);

    $this->post(route('otp.send', $user))
        ->assertRedirect(); // or however your controller handles the failure

    Africastalking::assertSmsSentTo('+254712345678');
});
```

`failSmsTo(array $phoneNumbers)` scopes the failure to specific recipients, leaving sends to other numbers unaffected — useful for testing partial-failure handling in bulk sends.

## Common Assertions

A few of the most commonly used assertions — see the [package README](https://github.com/samuelmwangiw/africastalking-laravel-tests#readme) for the full list, which also covers Voice, Airtime, Mobile Data, SIM Swap, Payments, Stash, Wallet, and Application balance checks:

| Method | Description |
|---|---|
| `assertSmsSentTo(string $phoneNumber)` | Asserts an SMS was sent to a specific number |
| `assertSmsContains(string $text)` | Asserts a sent SMS's body contains the given text |
| `assertSmsCount(int $count)` | Asserts exactly N SMS messages were sent |
| `assertNoSmsSent()` | Asserts no SMS was sent |
| `assertNothingDispatched()` | Asserts nothing was sent to Africa's Talking, across every service |
| `recorded(string $service): Collection` | Escape hatch returning the raw recorded `Saloon\Http\Response` objects for a service |

::: tip Every Domain Is Covered
The fake isn't SMS-only — Voice, Airtime, Mobile Data, SIM Swap, Payments, Stash, Wallet, and Application balance checks are all pre-wired with realistic default responses the moment you call `Africastalking::fake()`.
:::
