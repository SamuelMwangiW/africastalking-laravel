<?php

declare(strict_types=1);

namespace SamuelMwangiW\Africastalking\Tests\Fixtures;

use Illuminate\Notifications\Notification;
use SamuelMwangiW\Africastalking\Contracts\ReceivesSmsMessages;
use SamuelMwangiW\Africastalking\Facades\Africastalking;
use SamuelMwangiW\Africastalking\Notifications\AfricastalkingSmsChannel;

class BasicNotificationReturnsObject extends Notification
{
    public function via($notifiable)
    {
        return [AfricastalkingSmsChannel::class];
    }

    public function toAfricastalking(ReceivesSmsMessages $notifiable): \SamuelMwangiW\Africastalking\ValueObjects\Message
    {
        return Africastalking::sms('Basic Notification message.')
            ->to($notifiable->routeNotificationForAfricastalking($this));
    }
}
