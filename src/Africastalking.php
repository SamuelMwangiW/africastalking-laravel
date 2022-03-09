<?php

namespace SamuelMwangiW\Africastalking;

use SamuelMwangiW\Africastalking\Domain\Application;
use SamuelMwangiW\Africastalking\ValueObjects\Message;

class Africastalking
{
    public function application(): Application
    {
        return app(Application::class);
    }

    public function sms(?string $message = null): Message
    {
        return app(Message::class)->text($message);
    }
}
