<?php

declare(strict_types=1);

namespace SamuelMwangiW\Africastalking;

use SamuelMwangiW\Africastalking\Domain\Airtime;
use SamuelMwangiW\Africastalking\Domain\Application;
use SamuelMwangiW\Africastalking\Domain\MobileData;
use SamuelMwangiW\Africastalking\Domain\Payment;
use SamuelMwangiW\Africastalking\Domain\SimSwap;
use SamuelMwangiW\Africastalking\Domain\Stash;
use SamuelMwangiW\Africastalking\Domain\Voice;
use SamuelMwangiW\Africastalking\Domain\Wallet;
use SamuelMwangiW\Africastalking\Response\UssdResponse;
use SamuelMwangiW\Africastalking\ValueObjects\Message;

class Africastalking
{
    public function airtime(): Airtime
    {
        return app(Airtime::class);
    }

    public function app(): Application
    {
        return $this->application();
    }

    public function application(): Application
    {
        return app(Application::class);
    }

    public function payment(): Payment
    {
        return app(Payment::class);
    }

    public function bundles(): MobileData
    {
        return $this->mobileData();
    }

    public function insights(): SimSwap
    {
        return $this->simSwap();
    }

    public function simSwap(): SimSwap
    {
        return app(SimSwap::class);
    }

    public function mobileData(): MobileData
    {
        return app(MobileData::class);
    }

    public function sms(?string $message = null): Message
    {
        return app(Message::class)->text($message);
    }

    public function stash(): Stash
    {
        return app(Stash::class);
    }

    public function ussd(string $response = '', bool $expectsInput = true): UssdResponse
    {
        return app(UssdResponse::class, ['response' => $response, 'expectsInput' => $expectsInput]);
    }

    public function voice(): Voice
    {
        return app(Voice::class);
    }

    public function wallet(): Wallet
    {
        return app(Wallet::class);
    }
}
