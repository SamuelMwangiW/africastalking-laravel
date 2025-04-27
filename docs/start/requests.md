# HTTP Requests

The package ships with the following [Laravel Requests](https://laravel.com/docs/9.x/validation#creating-form-requests)
that you can inject into your application controllers:

```php
\SamuelMwangiW\Africastalking\Http\Requests\AirtimeStatusRequest::class;
\SamuelMwangiW\Africastalking\Http\Requests\AirtimeValidationRequest::class;
\SamuelMwangiW\Africastalking\Http\Requests\BulkSmsOptOutRequest::class;
\SamuelMwangiW\Africastalking\Http\Requests\IncomingMessageRequest::class;
\SamuelMwangiW\Africastalking\Http\Requests\MessageDeliveryRequest::class;
\SamuelMwangiW\Africastalking\Http\Requests\MobileC2BValidationRequest::class;
\SamuelMwangiW\Africastalking\Http\Requests\PaymentNotificationRequest::class;
\SamuelMwangiW\Africastalking\Http\Requests\SubscriptionRequest::class;
\SamuelMwangiW\Africastalking\Http\Requests\UssdEventRequest::class;
\SamuelMwangiW\Africastalking\Http\Requests\UssdSessionRequest::class;
\SamuelMwangiW\Africastalking\Http\Requests\VoiceCallRequest::class;
\SamuelMwangiW\Africastalking\Http\Requests\VoiceEventRequest::class;
```

In addition to exposing the post params in a nice FormRequest object, these classes also include nice helper methods
where applicable e.g.

- `id()` to retrieve the unique ATPid associated with every request
- `phone()` to retrieve the client's phone number
- `userInput()` to retrieve ussd user input
- `status()` to get transaction / request final status
- `deliveryFailed()` returns a boolean `true` if sms or airtime delivery failed and `false` otherwise
- among many others

Example for a Message Delivery callback action Controller

```php
<?php

namespace App\Http\Controllers\Messaging;

use App\Models\Message;
use SamuelMwangiW\Africastalking\Http\Requests\MessageDeliveryRequest;

class MessageDeliveredController{
    public function __invoke(MessageDeliveryRequest $request)
    {
        $message = Message::query()
                            ->where(['transaction_id'=>$request->id()])
                            ->firstOrFail();
                            
        $message->update([
            'delivered_at'=>now(),
            'status'=>$request->status(),
        ]);
        
        return response('OK');
    }
}

```