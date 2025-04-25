<?php

declare(strict_types=1);

namespace SamuelMwangiW\Africastalking\Tests\Fixtures;

use Illuminate\Notifications\Notification;
use SamuelMwangiW\Africastalking\Notifications\AfricastalkingChannel;
use SamuelMwangiW\Africastalking\ValueObjects\SentMessageResponse;

class FakeChannel extends AfricastalkingChannel
{
    public ?SentMessageResponse $results = null;
    public function send(object $notifiable, Notification $notification): SentMessageResponse
    {
        $this->results = parent::send($notifiable, $notification);

        return $this->results;
    }
}
