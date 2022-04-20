<?php

namespace SamuelMwangiW\Africastalking\Tests\Fixtures;

use Illuminate\Notifications\Notification;
use SamuelMwangiW\Africastalking\Facades\Africastalking;
use SamuelMwangiW\Africastalking\Notifications\AfricastalkingChannel;

class BasicNotificationReturnsObject extends Notification
{
    public function via($notifiable)
    {
        return [AfricastalkingChannel::class];
    }

    public function toAfricastalking($notifiable)
    {
        return Africastalking::sms('sample message here')
            ->to($notifiable->routeNotificationForAfricastalking($this));
    }
}
