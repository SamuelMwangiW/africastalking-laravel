<?php

declare(strict_types=1);

namespace SamuelMwangiW\Africastalking\Tests\Fixtures;

use Illuminate\Notifications\Notification;

class BasicNotification extends Notification
{
    use RoutesNotifications;
    public function __construct(public string $message) {}

    public function toAfricastalking(): string
    {
        return $this->message;
    }
}
