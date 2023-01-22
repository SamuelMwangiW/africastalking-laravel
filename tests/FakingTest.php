<?php

declare(strict_types=1);

use SamuelMwangiW\Africastalking\Domain\Airtime;
use SamuelMwangiW\Africastalking\Domain\VoiceCall;
use SamuelMwangiW\Africastalking\Facades\Africastalking;
use SamuelMwangiW\Africastalking\Testing\Fakes\AirtimeFake;
use SamuelMwangiW\Africastalking\Testing\Fakes\MessageFake;
use SamuelMwangiW\Africastalking\Testing\Fakes\VoiceCallFake;
use SamuelMwangiW\Africastalking\ValueObjects\Message;

it('swaps out implementation when a fake implementation', function (): void {
    Africastalking::fake();

    expect(app(Message::class))
        ->toBeInstanceOf(MessageFake::class)
        ->and(app(Airtime::class))->toBeInstanceOf(AirtimeFake::class)
        ->and(app(VoiceCall::class))->toBeInstanceOf(VoiceCallFake::class);
});

it('swapping does not persist', function (): void {
    expect(app(Message::class))
        ->toBeInstanceOf(Message::class)
        ->and(app(Airtime::class))->toBeInstanceOf(Airtime::class)
        ->and(app(VoiceCall::class))->toBeInstanceOf(VoiceCall::class);
});

it('asserts Message sent', function (string $phone, string $message): void {
    Africastalking::fake();

    Africastalking::sms($message)
        ->to($phone)
        ->send();

    Africastalking::sms($message)
        ->to([$phone,'+256706123123'])
        ->send();

    Africastalking::assertSmsSent();
})->with('phone-numbers', 'sentence');

it('asserts no sent', function (string $phone, string $message): void {
    Africastalking::fake();

    Africastalking::sms($message)
        ->to($phone);

    Africastalking::sms($message)
        ->to([$phone,'+256706123123']);

    Africastalking::assertNoSmsSent();
})->with('phone-numbers', 'sentence');

it('asserts VoiceCall sent', function (string $phone, string $message): void {
    Africastalking::fake();

    Africastalking::voice()->call($phone)->done();

    Africastalking::assertVoiceCallSent();
})->with('phone-numbers', 'sentence');

it('asserts no VoiceCall sent', function (string $phone, string $message): void {
    Africastalking::fake();

    Africastalking::voice()->call($phone);

    Africastalking::assertNoVoiceCallSent();
})->with('phone-numbers', 'sentence');

it('asserts AirtimeSent sent', function (string $phone, string $message): void {
    Africastalking::fake();

    Africastalking::airtime()->to(phoneNumber: $phone, currencyCode: 'KES', amount: 1_000)->send();
    Africastalking::airtime()->to(phoneNumber: $phone, currencyCode: 'UGX', amount: 3_000)->send();
    Africastalking::airtime()->to(phoneNumber: $phone, currencyCode: 'TZS', amount: 3_000)->send();

    Africastalking::assertAirtimeSent();
})->with('phone-numbers', 'sentence');

it('asserts no AirtimeSent sent', function (string $phone, string $message): void {
    Africastalking::fake();

    Africastalking::airtime()->to(phoneNumber: $phone, currencyCode: 'KES', amount: 1_000);
    Africastalking::airtime()->to(phoneNumber: $phone, currencyCode: 'UGX', amount: 3_000);
    Africastalking::airtime()->to(phoneNumber: $phone, currencyCode: 'TZS', amount: 3_000);

    Africastalking::assertNoAirtimeSent();
})->with('phone-numbers', 'sentence');
