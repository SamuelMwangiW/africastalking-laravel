<?php

declare(strict_types=1);

namespace SamuelMwangiW\Africastalking\Tests\Fixtures;

use Illuminate\Notifications\Notification;
use SamuelMwangiW\Africastalking\Contracts\ReceivesSmsMessages;

class BasicNotifiableNoTrait implements ReceivesSmsMessages
{
    public function routeNotificationForAfricastalking(Notification $notification): string
    {
        return '+254720123123';
    }
}
