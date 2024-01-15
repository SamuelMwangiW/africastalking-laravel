<?php

declare(strict_types=1);

use Saloon\Http\Faking\MockResponse;
use Saloon\Laravel\Facades\Saloon;
use SamuelMwangiW\Africastalking\Domain\VoiceCall;
use SamuelMwangiW\Africastalking\Facades\Africastalking;
use SamuelMwangiW\Africastalking\Saloon\Requests\Voice\CallRequest;
use SamuelMwangiW\Africastalking\ValueObjects\PhoneNumber;

use SamuelMwangiW\Africastalking\ValueObjects\VoiceCallResponse;

it('resolves the Voice class')
    ->expect(fn() => Africastalking::voice()->call())
    ->toBeInstanceOf(VoiceCall::class);

it('sets the recipients', function (): void {
    Saloon::fake([
        CallRequest::class => MockResponse::fixture('voice/call')
    ]);

    expect(
        Africastalking::voice()
            ->call('+254720123123')
            ->done()
    )->toBeInstanceOf(VoiceCallResponse::class)->toHaveKeys(['recipients', 'errorMessage']);
});

it('sets the phone number', function (): void {
    expect(Africastalking::voice()->call()->as('+254720123123'))
        ->from()->toBeInstanceOf(PhoneNumber::class)
        ->from()->number->toBe('+254720123123');
});

it('sets the phone number from env', function (): void {
    expect(Africastalking::voice()->call())
        ->from()->number->toBe(config('africastalking.voice.from'));
});

it('sets a call recipient', function (string $phone): void {
    expect(Africastalking::voice()->call($phone))
        ->data()
        ->toBeArray()
        ->toHaveKey('to')
        ->toMatchArray(['to' => $phone]);
})->with('phone-numbers');

it('sets a call recipient from PhoneNumber object', function (string $phone): void {
    expect(Africastalking::voice()->call(PhoneNumber::make($phone)))
        ->data()
        ->toBeArray()
        ->toHaveKey('to')
        ->toMatchArray(['to' => $phone]);
})->with('phone-numbers')
;

it('sets a call recipients from array', function (): void {
    $recipients = [
        fake()->e164PhoneNumber(),
        fake()->e164PhoneNumber(),
        fake()->e164PhoneNumber(),
        fake()->e164PhoneNumber(),
    ];
    expect(Africastalking::voice()->call($recipients))
        ->data()
        ->toBeArray()
        ->toHaveKey('to')
        ->toMatchArray(['to' => implode(',', $recipients)]);
});

it('sets a call clientRequestId', function (string $id): void {
    expect(Africastalking::voice()->call('not-relevant')->requestId($id))
        ->data()
        ->toBeArray()
        ->toHaveKey('clientRequestId')
        ->toMatchArray(['clientRequestId' => $id]);
})->with('strings');
