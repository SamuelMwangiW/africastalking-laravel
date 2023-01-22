<?php

declare(strict_types=1);

namespace SamuelMwangiW\Africastalking\Tests\Fixtures;

use Illuminate\Notifications\Notifiable;
use Illuminate\Notifications\Notification;
use SamuelMwangiW\Africastalking\Contracts\ReceivesSmsMessages;

class BasicNotifiable implements ReceivesSmsMessages
{
    use Notifiable;

    public function __construct(
        public string $phone = '+254720123123',
    ) {
    }

    public function routeNotificationForAfricastalking(Notification $notification): string
    {
        return $this->phone;
    }
}
