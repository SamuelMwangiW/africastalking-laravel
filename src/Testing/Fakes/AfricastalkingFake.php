<?php

declare(strict_types=1);

namespace SamuelMwangiW\Africastalking\Testing\Fakes;

use PHPUnit\Framework\Assert as PHPUnit;
use SamuelMwangiW\Africastalking\Africastalking;
use SamuelMwangiW\Africastalking\Domain\Airtime;
use SamuelMwangiW\Africastalking\Domain\VoiceCall;
use SamuelMwangiW\Africastalking\ValueObjects\Message;

class AfricastalkingFake extends Africastalking
{
    public function assertSmsSent(): void
    {
        $messages = app(Message::class)->messages() ?? [];

        PHPUnit::assertNotEmpty($messages, 'No messages were sent');
    }

    public function assertNoSmsSent(): void
    {
        $messages = app(Message::class)->messages() ?? [];

        PHPUnit::assertCount(0, $messages, 'Notifications were sent unexpectedly.');
    }

    public function assertVoiceCallSent(): void
    {
        $calls = app(VoiceCall::class)->calls() ?? [];

        PHPUnit::assertNotEmpty($calls, 'No calls were sent');
    }

    public function assertNoVoiceCallSent(): void
    {
        $calls = app(VoiceCall::class)->calls() ?? [];

        PHPUnit::assertEmpty($calls, 'No calls were sent');
    }

    public function assertAirtimeSent(): void
    {
        $transactions = app(Airtime::class)->transactions();

        PHPUnit::assertNotEmpty($transactions, 'No airtime request was sent');
    }

    public function assertNoAirtimeSent(): void
    {
        $transactions = app(Airtime::class)->transactions();

        PHPUnit::assertEmpty($transactions, 'Airtime request was sent by mistake');
    }
}
