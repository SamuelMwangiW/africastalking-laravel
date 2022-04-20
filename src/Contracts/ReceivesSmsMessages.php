<?php

namespace SamuelMwangiW\Africastalking\Contracts;

use Illuminate\Notifications\Notification;

interface ReceivesSmsMessages
{
    public function routeNotificationForAfricastalking(Notification $notification): string;
}
