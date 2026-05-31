# Laravel Notifications via SMS

This package includes a Laravel notification channel that lets you send SMS messages through Africa's Talking using Laravel's standard `Notification` system — no custom HTTP calls needed.

## Step 1: Create a Notification

Return `AfricastalkingChannel::class` from the `via()` method and implement `toAfricastalking()` to return the message text:

```php
<?php

namespace App\Notifications;

use Illuminate\Notifications\Notification;
use SamuelMwangiW\Africastalking\Notifications\AfricastalkingChannel;

class WelcomeNotification extends Notification
{
    public function via(object $notifiable): array
    {
        return [AfricastalkingChannel::class];
    }

    public function toAfricastalking(object $notifiable): string
    {
        return "Hi {$notifiable->name}, your account has been created. Welcome aboard!";
    }
}
```

## Step 2: Implement the Contract on Your Model

Your notifiable model (usually `User`) must implement `ReceivesSmsMessages` and define `routeNotificationForAfricastalking()` to return the recipient's phone number:

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

    protected $fillable = ['email', 'name', 'phone'];

    public function routeNotificationForAfricastalking(Notification $notification): string
    {
        return $this->phone;
    }
}
```

## Step 3: Send the Notification

Use Laravel's standard `notify()` method — nothing new to learn:

```php
$user->notify(new WelcomeNotification());
```

Or notify multiple users at once:

```php
use Illuminate\Support\Facades\Notification;

Notification::send(User::all(), new WelcomeNotification());
```

## On-Demand Notifications

To send an SMS to a phone number not associated with any model, use Laravel's on-demand notification routing:

```php
use Illuminate\Support\Facades\Notification;
use SamuelMwangiW\Africastalking\Notifications\AfricastalkingChannel;

Notification::route(AfricastalkingChannel::class, '+254722000000')
    ->notify(new WelcomeNotification());
```

See the [On-Demand SMS](../sms/ondemand) page for a full example notification class designed for this pattern.
