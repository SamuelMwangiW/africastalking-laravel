<?php

namespace SamuelMwangiW\Africastalking\Tests\Fixtures;

use Illuminate\Notifications\Notification;
use SamuelMwangiW\Africastalking\Notifications\AfricastalkingChannel;

class BasicNotificationNoToAfricastalking extends Notification
{
    public function via($notifiable)
    {
        return [AfricastalkingChannel::class];
    }
}
