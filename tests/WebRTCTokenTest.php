<?php

use Saloon\Http\Faking\MockResponse;
use Saloon\Laravel\Facades\Saloon;
use SamuelMwangiW\Africastalking\Domain\WebRTCToken;
use SamuelMwangiW\Africastalking\Saloon\Requests\Voice\CapabilityTokenRequest;
use SamuelMwangiW\Africastalking\ValueObjects\CapabilityToken;

it("can be initialized")
    ->expect(fn() => new WebRTCToken())
    ->toBeInstanceOf(WebRTCToken::class);

test("clientName can be set dynamically", function (string $word) {
    $object = (new WebRTCToken())->for($word);

    expect($object)
        ->toBeInstanceOf(WebRTCToken::class)
        ->clientName()->toBe($word);
})->with('strings');

test("phoneNumber can be set dynamically", function (string $phone) {
    $object = (new WebRTCToken())->from($phone);

    expect($object)
        ->toBeInstanceOf(WebRTCToken::class)
        ->phone()->toBe($phone);
})->with('phone-numbers');

test("validity can be set dynamically", function (int $number) {
    $object = (new WebRTCToken())->validFor($number);

    expect($object)
        ->toBeInstanceOf(WebRTCToken::class)
        ->validity->toBe($number)
        ->expire()->toBe("{$number}s");
})->with('webrtc-token-duration');

it("throws an exception for invalid validity", function (int $number) {
    (new WebRTCToken())->validFor($number);
})
    ->with('invalid-token-duration')
    ->throws(InvalidArgumentException::class);

it("generates data array", function (string $word, string $phone, int $duration) {
    $object = (new WebRTCToken())
        ->for($word)
        ->validFor($duration)
        ->from($phone);

    expect($object)
        ->toBeInstanceOf(WebRTCToken::class)
        ->data()->toBeArray()
        ->toBe([
            "phoneNumber" => $phone,
            "clientName" => $word,
            "incoming" => "true",
            "outgoing" => "true",
            "expire" => "{$duration}s",
        ]);
})->with('strings', 'phone-numbers', 'webrtc-token-duration');

it('requests a webrtc capability token', function (): void {
    config()->set('africastalking.username', 'not_sandbox');

    Saloon::fake([
        CapabilityTokenRequest::class => MockResponse::fixture('voice/capability-token')
    ]);

    $response = africastalking()->voice()
        ->webrtc()
        ->for('John.Doe')
        ->send();

    expect($response)
        ->toBeInstanceOf(CapabilityToken::class)
        ->clientName->toBe('John.Doe')
        ->incoming->toBeTrue()
        ->outgoing->toBeTrue()
        ->lifeTimeSec->toBeInt()->toBe(86400);
});
