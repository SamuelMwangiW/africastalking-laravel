# HTTP Callback Requests

Africa's Talking sends POST callbacks to your application for delivery reports, incoming messages, payment notifications, USSD sessions, and voice events. This package ships with typed [Laravel Form Requests](https://laravel.com/docs/validation#creating-form-requests) that validate these callbacks and expose their data via named helper methods.

## Available Request Classes

| Class | Callback Type |
|---|---|
| `AirtimeStatusRequest` | Airtime delivery status |
| `AirtimeValidationRequest` | Airtime validation callback |
| `BulkSmsOptOutRequest` | Bulk SMS opt-out |
| `IncomingMessageRequest` | Incoming SMS message |
| `MessageDeliveryRequest` | SMS delivery report |
| `MobileC2BValidationRequest` | Mobile payment C2B validation |
| `PaymentNotificationRequest` | Payment notification |
| `SubscriptionRequest` | Premium SMS subscription |
| `UssdEventRequest` | USSD session event |
| `UssdSessionRequest` | USSD session data |
| `VoiceCallRequest` | Incoming / active voice call |
| `VoiceEventRequest` | Voice call event |

All classes live under `SamuelMwangiW\Africastalking\Http\Requests`.

## Common Helper Methods

Each request class exposes relevant helpers — no manual `$request->input('key')` needed:

| Method | Return Type | Description |
|---|---|---|
| `id()` | `string` | The unique AT transaction/message ID |
| `phone()` | `string` | The caller or sender's phone number |
| `userInput()` | `string` | USSD user input text |
| `status()` | `string` | Final status of a transaction or message |
| `deliveryFailed()` | `bool` | `true` if SMS or airtime delivery failed |

## Example: SMS Delivery Callback

Register a POST route for Africa's Talking to call when a message is delivered:

```php
// routes/api.php
Route::post('/callbacks/sms/delivery', [MessageDeliveredController::class, '__invoke']);
```

Then handle it in your controller:

```php
<?php

namespace App\Http\Controllers\Messaging;

use App\Models\Message;
use SamuelMwangiW\Africastalking\Http\Requests\MessageDeliveryRequest;

class MessageDeliveredController
{
    public function __invoke(MessageDeliveryRequest $request)
    {
        $message = Message::query()
            ->where('transaction_id', $request->id())
            ->firstOrFail();

        $message->update([
            'delivered_at' => now(),
            'status'       => $request->status(),
        ]);

        return response('OK');
    }
}
```

## Example: Airtime Status Callback

```php
<?php

namespace App\Http\Controllers\Airtime;

use App\Models\AirtimeTransaction;
use SamuelMwangiW\Africastalking\Http\Requests\AirtimeStatusRequest;

class AirtimeStatusController
{
    public function __invoke(AirtimeStatusRequest $request)
    {
        AirtimeTransaction::query()
            ->where('transaction_id', $request->id())
            ->update([
                'status'     => $request->status(),
                'failed'     => $request->deliveryFailed(),
                'updated_at' => now(),
            ]);

        return response('OK');
    }
}
```

## Example: Incoming SMS Callback

```php
<?php

namespace App\Http\Controllers\Messaging;

use App\Models\InboundMessage;
use SamuelMwangiW\Africastalking\Http\Requests\IncomingMessageRequest;

class IncomingSmsController
{
    public function __invoke(IncomingMessageRequest $request)
    {
        InboundMessage::create([
            'from'    => $request->phone(),
            'message' => $request->input('text'),
            'at_id'   => $request->id(),
        ]);

        return response('OK');
    }
}
```

::: tip
Always return `response('OK')` (HTTP 200) from your callback controllers. Africa's Talking will retry the callback if it does not receive a `2xx` response.
:::
