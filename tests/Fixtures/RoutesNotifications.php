<?php

declare(strict_types=1);

namespace SamuelMwangiW\Africastalking\Tests\Fixtures;

use Illuminate\Notifications\AnonymousNotifiable;
use SamuelMwangiW\Africastalking\Notifications\AfricastalkingChannel;

trait RoutesNotifications
{
    public function via(object $notifiable): array
    {
        return $notifiable instanceof AnonymousNotifiable
            ? array_keys($notifiable->routes)
            : [AfricastalkingChannel::class];
    }
}
