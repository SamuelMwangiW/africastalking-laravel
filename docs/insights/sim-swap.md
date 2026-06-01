# SIM Swap Detection

The SIM Swap API checks whether a phone number has had its SIM card recently swapped. A recent SIM swap is a common indicator of fraud — attackers swap a victim's SIM to intercept OTPs and bypass two-factor authentication.

Use this API as an additional security layer before processing sensitive operations like fund transfers, password resets, or account changes.

## Basic Usage

```php
use SamuelMwangiW\Africastalking\Facades\Africastalking;

$result = Africastalking::insights()
    ->for('+254722000000')
    ->send();
```

`simSwap()` is an alias for `insights()`:

```php
$result = Africastalking::simSwap()
    ->for('+254722000000')
    ->send();
```

## Checking Multiple Numbers

```php
$result = Africastalking::insights()
    ->for('+254711000000')
    ->add('+254722000000')
    ->add('+256786000000')
    ->send();
```

## Idempotency

Pass a unique idempotency key to prevent duplicate API calls from being processed more than once:

```php
$result = Africastalking::insights()
    ->for('+254722000000')
    ->idempotent('b457c437-72cd-46b1-b450-d3a12c400810')
    ->send();
```

## Example: Block Suspicious Transactions

`send()` returns an `InsightsResponse`. Per-number results are in the `->items` collection, each an `InsightsResponseItem` with a `status` property. A status other than `Success` (e.g. `Failed` or `UnsupportedPhoneNumber`) should be treated as a risk signal:

```php
use SamuelMwangiW\Africastalking\Enum\Status;
use SamuelMwangiW\Africastalking\Facades\Africastalking;

public function initiateTransfer(Request $request)
{
    $result = Africastalking::insights()
        ->for($request->user()->phone)
        ->send();

    $isAtRisk = $result->items->contains(
        fn($item) => $item->status !== Status::SUCCESS
    );

    if ($isAtRisk) {
        return response()->json([
            'error' => 'Your SIM card was recently changed. For your security, please visit a branch to verify your identity.',
        ], 403);
    }

    // Proceed with the transfer...
}
```

## Use Cases

| Sector | Application |
|---|---|
| **Financial Services** | Block transactions when a recent SIM swap is detected before funds move |
| **Healthcare** | Protect patient account access and telemedicine logins |
| **Logistics** | Prevent unauthorised access to shipment tracking or driver accounts |
| **E-Commerce** | Add a fraud check during high-value purchases or account changes |

::: warning
SIM Swap detection is an additional signal, not a definitive fraud verdict. Combine it with other controls (e.g. biometrics, security questions) for robust fraud prevention.
:::
