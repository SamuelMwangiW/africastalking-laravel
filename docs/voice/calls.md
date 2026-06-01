# Making Outbound Calls

Initiate outbound voice calls to one or many phone numbers programmatically.

## Basic Call

```php
africastalking()->voice()
    ->call('+254720123123')
    ->send();
```

## Calling Multiple Numbers

Pass an array to call several numbers simultaneously:

```php
africastalking()->voice()
    ->call(['+254720123123', '+254731234567'])
    ->send();
```

## Method Reference

| Method | Description |
|---|---|
| `call(string\|array $numbers)` | The phone number(s) to call |
| `as(string $callerId)` | Override the caller ID (must be a registered number) |
| `requestId(string $id)` | Attach a custom reference ID to the call |
| `send()` | Dispatch the call request (alias: `done()`) |
| `done()` | Alias for `send()` |

## Override the Caller ID

```php
africastalking()->voice()
    ->call('+254720123123')
    ->as('+254711082999')
    ->send();
```

## Attach a Request ID

Useful for correlating the call with a record in your database:

```php
africastalking()->voice()
    ->call('+254720123123')
    ->requestId('order-9876-call')
    ->send();
```

## Example: Appointment Reminder

```php
<?php

namespace App\Http\Controllers;

use App\Models\Appointment;

class AppointmentReminderController
{
    public function call(Appointment $appointment)
    {
        africastalking()->voice()
            ->call($appointment->patient_phone)
            ->requestId("appt-{$appointment->id}")
            ->send();

        return response()->json(['message' => 'Reminder call initiated']);
    }
}
```

::: tip
After the call connects, Africa's Talking will POST to your voice callback URL. Handle it with a [Voice Response](./responses) to play a message or collect input from the caller.
:::
