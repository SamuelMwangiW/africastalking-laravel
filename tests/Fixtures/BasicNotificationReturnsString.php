<?php

declare(strict_types=1);

namespace SamuelMwangiW\Africastalking\Tests\Fixtures;

use Illuminate\Notifications\Notification;
use SamuelMwangiW\Africastalking\Notifications\AfricastalkingChannel;

class BasicNotificationReturnsString extends Notification
{
    public function via($notifiable): array
    {
        return [AfricastalkingChannel::class];
    }

    public function toAfricastalking(): string
    {
        return 'String notification string message';
    }
}
