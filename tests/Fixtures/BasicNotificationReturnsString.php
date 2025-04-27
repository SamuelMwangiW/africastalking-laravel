<?php

declare(strict_types=1);

namespace SamuelMwangiW\Africastalking\Tests\Fixtures;

use Illuminate\Notifications\Notification;

class BasicNotificationReturnsString extends Notification
{
    use RoutesNotifications;

    public function toAfricastalking(): string
    {
        return 'String notification string message';
    }
}
