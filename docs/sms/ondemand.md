# On-Demand SMS

On-demand SMS lets you send a one-off message to any phone number without needing a pre-existing notifiable model. It uses Laravel's on-demand notification routing with the `AfricastalkingChannel`.

## Quick Send

```php
use Illuminate\Support\Facades\Notification;
use App\Notifications\SendSmsMessage;
use SamuelMwangiW\Africastalking\Notifications\AfricastalkingChannel;

Notification::route(AfricastalkingChannel::class, '+254722000000')
    ->notify(new SendSmsMessage(message: 'Your verification code is 847291'));
```

## The Notification Class

Create a notification that accepts a message string and returns it via the `toAfricastalking()` method:

```php
<?php

namespace App\Notifications;

use Illuminate\Notifications\Notification;
use SamuelMwangiW\Africastalking\Notifications\AfricastalkingChannel;

class SendSmsMessage extends Notification
{
    public function __construct(public string $message = '')
    {
    }

    public function via(object $notifiable): array
    {
        return [AfricastalkingChannel::class];
    }

    public function toAfricastalking(object $notifiable): string
    {
        return $this->message;
    }
}
```

## Real-World Example: OTP Delivery

```php
<?php

namespace App\Http\Controllers\Auth;

use App\Notifications\SendSmsMessage;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Notification;
use SamuelMwangiW\Africastalking\Notifications\AfricastalkingChannel;

class OtpController
{
    public function send(Request $request)
    {
        $request->validate(['phone' => 'required|string']);

        $otp = random_int(100000, 999999);

        // Store OTP for verification...
        cache()->put("otp:{$request->phone}", $otp, now()->addMinutes(5));

        Notification::route(AfricastalkingChannel::class, $request->phone)
            ->notify(new SendSmsMessage(message: "Your OTP is {$otp}. It expires in 5 minutes."));

        return response()->json(['message' => 'OTP sent successfully']);
    }
}
```

::: tip When to use On-Demand vs. Model Notifications
Use on-demand when you don't have (or don't need) a User/model record for the recipient — e.g., during registration, anonymous enquiries, or external contacts. For notifications tied to authenticated users, use the [standard notification channel](../start/notification) instead.
:::
