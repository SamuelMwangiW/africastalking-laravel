<?php

namespace SamuelMwangiW\Africastalking\Tests\Fixtures;

use Illuminate\Notifications\Notification;
use SamuelMwangiW\Africastalking\Notifications\AfricastalkingChannel;

class BasicNotificationReturnsString extends Notification
{
    public function via($notifiable)
    {
        return [AfricastalkingChannel::class];
    }

    public function toAfricastalking()
    {
        return 'sample message here';
    }
}
