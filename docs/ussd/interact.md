# USSD Sessions

USSD (Unstructured Supplementary Service Data) enables menu-driven interactions over mobile networks without internet access. This package provides a `UssdResponse` class and typed request objects for handling USSD sessions.

## How USSD Works

1. A user dials a USSD shortcode (e.g. `*123#`).
2. Africa's Talking sends a POST request to your callback URL with session data.
3. Your app responds with a text prompt and indicates whether more input is expected.
4. The user replies, and the cycle repeats until the session ends.

## The `UssdResponse` Class

Return `africastalking()->ussd()` from your controller to send a USSD response. It implements Laravel's `Responsable` contract, so you can return it directly.

| Method | Description |
|---|---|
| `ussd(string $text, bool $expectsInput = true)` | Create a response with optional text and input expectation |
| `->response(string $text)` | Set or update the response text |
| `->expectsInput(bool $value)` | Whether to prompt the user for more input |
| `->end()` | Alias for `->expectsInput(false)` — terminates the session |

## Setting Up Routes

Register a POST route for Africa's Talking to call:

```php
// routes/api.php
Route::post('/ussd/session', [UssdController::class, 'session']);
Route::post('/ussd/event', [UssdController::class, 'event']);
```

## Example USSD Controller

```php
<?php

namespace App\Http\Controllers;

use App\Models\Client;
use Illuminate\Support\Str;
use SamuelMwangiW\Africastalking\Http\Requests\UssdEventRequest;
use SamuelMwangiW\Africastalking\Http\Requests\UssdSessionRequest;

class UssdController extends Controller
{
    public function session(UssdSessionRequest $request)
    {
        // No input yet — show the initial menu
        if (! $request->userInput()) {
            return africastalking()->ussd('Welcome! Please enter your account number:');
        }

        // Extract the last input segment (accounts for multi-step navigation)
        $accountNo = Str::of($request->userInput())->afterLast('*')->toString();

        $account = Client::query()->whereAccountNo($accountNo)->first();

        if ($account) {
            return africastalking()
                ->ussd("Your balance is KES {$account->balance}. Thank you!")
                ->end(); // terminates the session
        }

        return africastalking()
            ->ussd("Account not found.\n\nPlease enter a valid account number:");
    }

    public function event(UssdEventRequest $request)
    {
        // Handle session timeout or user hang-up
        return response('OK');
    }
}
```

## Multi-Step Menu Example

USSD menus can have multiple levels. Use the session's `userInput()` to determine which step the user is on:

```php
public function session(UssdSessionRequest $request)
{
    $input = $request->userInput();

    // Step 1 — no input yet
    if (! $input) {
        return africastalking()->ussd(
            "MyBank USSD\n1. Check Balance\n2. Send Money\n3. Airtime"
        );
    }

    // Step 2 — user selected a menu item
    return match ($input) {
        '1' => africastalking()->ussd("Your balance is KES 4,200.00")->end(),
        '2' => africastalking()->ussd("Enter recipient phone number:"),
        '3' => africastalking()->ussd("Enter airtime amount (KES):"),
        default => africastalking()->ussd("Invalid option. Please try again.\n\n1. Check Balance\n2. Send Money\n3. Airtime"),
    };
}
```

::: tip Session Input Format
For multi-step sessions, Africa's Talking concatenates all user inputs with `*`. For example, if the user chose `2` and then typed `0722000000`, `userInput()` returns `2*0722000000`. Use `Str::afterLast('*')` to get the most recent input.
:::
