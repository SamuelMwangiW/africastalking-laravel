<?php

declare(strict_types=1);

namespace SamuelMwangiW\Africastalking\Tests\Fixtures;

use Illuminate\Notifications\Notification;
use SamuelMwangiW\Africastalking\Notifications\AfricastalkingChannel;

class BasicNotification extends Notification
{
    public function __construct(public string $message) {}

    public function via(object $notifiable): array
    {
        return [AfricastalkingChannel::class];
    }

    public function toAfricastalking(): string
    {
        return $this->message;
    }
}
