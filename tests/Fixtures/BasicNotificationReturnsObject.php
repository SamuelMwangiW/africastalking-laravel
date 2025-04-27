<?php

declare(strict_types=1);

namespace SamuelMwangiW\Africastalking\Tests\Fixtures;

use Illuminate\Notifications\Notification;
use SamuelMwangiW\Africastalking\Contracts\ReceivesSmsMessages;
use SamuelMwangiW\Africastalking\Facades\Africastalking;
use SamuelMwangiW\Africastalking\ValueObjects\Message;

class BasicNotificationReturnsObject extends Notification
{
    use RoutesNotifications;

    public function toAfricastalking(ReceivesSmsMessages $notifiable): Message
    {
        return Africastalking::sms('Basic Notification message.')->to(
            recipients: $notifiable->routeNotificationForAfricastalking($this),
        );
    }
}
