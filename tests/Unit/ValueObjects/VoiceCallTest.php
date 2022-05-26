<?php

use function Pest\Faker\faker;
use SamuelMwangiW\Africastalking\Domain\VoiceCall;
use SamuelMwangiW\Africastalking\Facades\Africastalking;
use SamuelMwangiW\Africastalking\ValueObjects\PhoneNumber;

it('resolves the Voice class')
    ->expect(fn () => Africastalking::voice()->call())
    ->toBeInstanceOf(VoiceCall::class);

it('sets the recipients', function () {
    expect(
        Africastalking::voice()
        ->call('+254720123123')
        ->done()
    )->toBeArray()->toHaveKeys(['entries', 'errorMessage']);
});

it('sets the phone number', function () {
    expect(Africastalking::voice()->call()->as('+254720123123'))
        ->from()->toBeInstanceOf(PhoneNumber::class)
        ->from()->number->toBe('+254720123123');
});

it('sets the phone number from env', function () {
    expect(Africastalking::voice()->call())
        ->from()->number->toBe(config('africastalking.voice.from'));
});

it('sets a call recipient', function (string $phone) {
    expect(Africastalking::voice()->call($phone))
        ->data()
        ->toBeArray()
        ->toHaveKey('to')
        ->toMatchArray(['to' => $phone]);
})->with('phone-numbers');

it('sets a call recipient from PhoneNumber object', function (string $phone) {
    expect(Africastalking::voice()->call(PhoneNumber::make($phone)))
        ->data()
        ->toBeArray()
        ->toHaveKey('to')
        ->toMatchArray(['to' => $phone]);
})->with('phone-numbers');

it('sets a call recipients from array', function () {
    $recipients = [
        faker()->e164PhoneNumber(),
        faker()->e164PhoneNumber(),
        faker()->e164PhoneNumber(),
        faker()->e164PhoneNumber(),
    ];
    expect(Africastalking::voice()->call($recipients))
        ->data()
        ->toBeArray()
        ->toHaveKey('to')
        ->toMatchArray(['to' => implode(',', $recipients)]);
});

it('sets a call clientRequestId', function (string $id) {
    expect(Africastalking::voice()->call('not-relevant')->requestId($id))
        ->data()
        ->toBeArray()
        ->toHaveKey('clientRequestId')
        ->toMatchArray(['clientRequestId' => $id]);
})->with('strings');
