<?php

declare(strict_types=1);

namespace SamuelMwangiW\Africastalking\Tests\Fixtures;

use Illuminate\Notifications\AnonymousNotifiable;
use Illuminate\Notifications\Notification;
use SamuelMwangiW\Africastalking\Contracts\ReceivesSmsMessages;
use SamuelMwangiW\Africastalking\Notifications\AfricastalkingChannel;
use SamuelMwangiW\Africastalking\ValueObjects\SentMessageResponse;

class FakeChannel extends AfricastalkingChannel
{
    public SentMessageResponse $results;
    public function send(ReceivesSmsMessages|AnonymousNotifiable $notifiable, Notification $notification): SentMessageResponse
    {
        return $this->results = parent::send($notifiable, $notification);
    }
}
