<?php

declare(strict_types=1);

namespace SamuelMwangiW\Africastalking\Contracts;

use Illuminate\Notifications\Notification;

interface ReceivesSmsMessages
{
    public function routeNotificationForAfricastalking(Notification $notification): string;
}
