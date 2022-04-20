<?php

namespace SamuelMwangiW\Africastalking\Tests\Fixtures;

use Illuminate\Notifications\Notifiable;
use Illuminate\Notifications\Notification;
use SamuelMwangiW\Africastalking\Contracts\ReceivesSmsMessages;

class BasicNotifiable implements ReceivesSmsMessages
{
    use Notifiable;

    public function routeNotificationForAfricastalking(Notification $notification): string
    {
        return '+254720123123';
    }
}
