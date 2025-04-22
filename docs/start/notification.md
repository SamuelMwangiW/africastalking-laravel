# Notification

The package ships with a Channel to allow for easily routing of notifications via Africastalking SMS.

To route a notification via Africastalking, return `SamuelMwangiW\Africastalking\Notifications\AfricastalkingChannel` in
your notifications `via` method and the text message to be sent in the `toAfricastalking` method

```php
<?php

namespace App\Notifications;

use Illuminate\Notifications\Notification;
use SamuelMwangiW\Africastalking\Facades\Africastalking;
use SamuelMwangiW\Africastalking\Notifications\AfricastalkingChannel;

class WelcomeNotification extends Notification
{
    public function via($notifiable)
    {
        return [AfricastalkingChannel::class];
    }

    public function toAfricastalking($notifiable)
    {
        return "Hi {$notifiable->name}. Your account at Unicorn Bank has been created. Hope you enjoy the service";
    }
}

```

Also ensure that the notifiable model implements `SamuelMwangiW\Africastalking\Contracts\ReceivesSmsMessages` and that
the model's `routeNotificationForAfricastalking()` returns the phone number to receive the message

```php
<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Notifications\Notifiable;
use Illuminate\Notifications\Notification;
use SamuelMwangiW\Africastalking\Contracts\ReceivesSmsMessages;

class User extends Model implements ReceivesSmsMessages
{
    protected $fillable = ['email','name','phone'];

    public function routeNotificationForAfricastalking(Notification $notification): string
    {
        return $this->phone;
    }
}

```