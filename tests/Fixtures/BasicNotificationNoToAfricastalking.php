<?php

declare(strict_types=1);

namespace SamuelMwangiW\Africastalking\Tests\Fixtures;

use Illuminate\Notifications\Notification;

class BasicNotificationNoToAfricastalking extends Notification
{
    use RoutesNotifications;
}
