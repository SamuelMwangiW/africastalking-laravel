<?php

declare(strict_types=1);

namespace SamuelMwangiW\Africastalking\Tests\Fixtures;

use Illuminate\Notifications\Notification;
use SamuelMwangiW\Africastalking\Notifications\AfricastalkingSmsChannel;

class BasicNotificationNoToAfricastalking extends Notification
{
    public function via($notifiable): array
    {
        return [AfricastalkingSmsChannel::class];
    }
}
