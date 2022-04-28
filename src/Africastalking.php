<?php

namespace SamuelMwangiW\Africastalking;

use SamuelMwangiW\Africastalking\Domain\Airtime;
use SamuelMwangiW\Africastalking\Domain\Application;
use SamuelMwangiW\Africastalking\Domain\Stash;
use SamuelMwangiW\Africastalking\Domain\Wallet;
use SamuelMwangiW\Africastalking\Response\UssdResponse;
use SamuelMwangiW\Africastalking\ValueObjects\Message;

class Africastalking
{
    public function airtime(): Airtime
    {
        return app(Airtime::class);
    }

    public function application(): Application
    {
        return app(Application::class);
    }

    public function sms(?string $message = null): Message
    {
        return app(Message::class)->text($message);
    }

    public function ussd(string $response = '', bool $expectsInput = true): UssdResponse
    {
        return app(UssdResponse::class, ['response' => $response, 'expectsInput' => $expectsInput]);
    }

    public function stash(): Stash
    {
        return app(Stash::class);
    }

    public function wallet(): Wallet
    {
        return app(Wallet::class);
    }
}
