# Sending OnDemand Messages

You can quickly send on-demand SMS messages to any phone number using Laravel's notification system with the Africastalking channel.

```php
use App\Notifications\SendSmsMessage;
use SamuelMwangiW\Africastalking\Notifications\AfricastalkingChannel;

Notification::route(AfricastalkingChannel::class, '254722000000' )
    ->notify( new SendSmsMessage(message: 'Sample SMS'));
```


The notification class must implement the `toAfricastalking` method to work with the Africastalking channel.


```php
# App\Notifications\SendSmsMessage;

<?php

declare(strict_types=1);

namespace App\Notifications;

use SamuelMwangiW\Africastalking\Notifications\AfricastalkingChannel;

class SendSmsMessage extends BaseNotification
{
    public function __construct(public string $message = '')
    {
    }

    public function via(object $notifiable): array
    {
        return [AfricastalkingChannel::class];
    }

    public function toAfricastalking($notifiable): string
    {
        return $this->message;
    }
}

```
