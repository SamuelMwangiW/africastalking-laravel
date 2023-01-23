<?php

declare(strict_types=1);

use Illuminate\Contracts\Support\Responsable;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Saloon\Http\Faking\MockResponse;
use Saloon\Laravel\Saloon;
use SamuelMwangiW\Africastalking\Domain\Voice;
use SamuelMwangiW\Africastalking\Domain\WebRTCToken;
use SamuelMwangiW\Africastalking\Facades\Africastalking;
use SamuelMwangiW\Africastalking\Response\VoiceResponse;
use SamuelMwangiW\Africastalking\ValueObjects\CapabilityToken;
use SamuelMwangiW\Africastalking\ValueObjects\Voice\SynthesisedSpeech;
use Symfony\Component\HttpFoundation\ResponseHeaderBag;

it('resolves the application class')
    ->expect(fn () => Africastalking::voice())
    ->toBeInstanceOf(Voice::class);

it('forwards calls to VoiceResponse class')
    ->expect(fn () => Africastalking::voice()->reject())
    ->toBeInstanceOf(VoiceResponse::class);

it('implements the Responsable class')
    ->expect(fn () => app(VoiceResponse::class))
    ->toBeInstanceOf(Responsable::class);

it('can chain actions fluently')
    ->expect(
        fn () => Africastalking::voice()
            ->say('Hey and welcome to Unicorn bank.')
            ->getDigits(
                say: 'Enter your account followed by the hash key',
                finishOnKey: '#'
            )->dial(['+2547123000', 'test@sip.ke.africastalking.com'])
            ->play('https://example.com/playback.wav')
            ->record('Please be nice, you are being recorded')
            ->redirect('https://example.com/redirect.jsp')
            ->getResponse()
    )->toBe(
        '<?xml version="1.0" encoding="UTF-8"?><Response><Say>Hey and welcome to Unicorn bank.</Say><GetDigits finishOnKey="#"><Say>Enter your account followed by the hash key</Say></GetDigits><Dial phoneNumbers="+2547123000,test@sip.ke.africastalking.com"/><Play url="https://example.com/playback.wav"/><Record><Say>Please be nice, you are being recorded</Say></Record><Redirect>https://example.com/redirect.jsp</Redirect></Response>'
    );

it('can chain synthesized speech actions fluently')
    ->expect(
        fn () => Africastalking::voice()
            ->say(
                fn (SynthesisedSpeech $speech) => $speech
                    ->say('Hey and welcome to Unicorn bank.')
                    ->emphasis(' where we treat you ')
                    ->bleep('very nicely')
                    ->sayAsOrdinal('SAP')
                    ->sayAsCurrency('$100', 'en-US')
            )->play('https://example.com/playback.wav')
            ->getResponse()
    )->toBe(
        '<?xml version="1.0" encoding="UTF-8"?><Response><Say><speak>Hey and welcome to Unicorn bank.<emphasis level="strong"> where we treat you </emphasis><say-as interpret-as="bleep">very nicely</say-as><say-as interpret-as="ordinal">SAP</say-as><say-as interpret-as="currency" language="en-US">$100</say-as></speak></Say><Play url="https://example.com/playback.wav"/></Response>'
    );

it('can reject calls')
    ->expect(
        fn () => Africastalking::voice()
            ->play('We are closed at the moment, kindly call tomorrow')
            ->reject()
            ->getResponse()
    )->toBe(
        '<?xml version="1.0" encoding="UTF-8"?><Response><Play url="We are closed at the moment, kindly call tomorrow"/><Reject/></Response>'
    );

it('sets content-type to text/plain in the response', function (): void {
    $request = Request::create(uri: '/');

    $response = Africastalking::voice()
        ->getDigits('Please enter your account number')
        ->toResponse($request);

    expect($response)
        ->toBeInstanceOf(Response::class)
        ->content()->toBe(
            '<?xml version="1.0" encoding="UTF-8"?><Response><GetDigits><Say>Please enter your account number</Say></GetDigits></Response>'
        )
        ->headers->toBeInstanceOf(ResponseHeaderBag::class)
        ->headers->get('content-type')->toBe('application/xml');
});

it('makes a call', function (string $phone): void {
    $response = africastalking()->voice()->call($phone)->send();

    expect($response)
        ->toBeArray()
        ->toHaveKeys(['entries', 'errorMessage'])
        ->and($response['errorMessage'])->toBeIn(['None', 'Invalid callbackUrl: ', 'Invalid callerId: ']);
})->with('phone-numbers');

it('initiates a webrtc object')
    ->expect(
        fn () => africastalking()->voice()->webrtc()
    )->toBeInstanceOf(WebRTCToken::class);

it('sets the client while initiating a webrtc object')
    ->expect(
        fn () => africastalking()->voice()->webrtc('John.Doe')
    )->toBeInstanceOf(WebRTCToken::class)
    ->clientName->toBe('John.Doe');

it('sets the client for a webrtc object')
    ->expect(
        fn () => africastalking()->voice()->webrtc()->for('John.Doe')
    )->toBeInstanceOf(WebRTCToken::class)
    ->clientName->toBe('John.Doe');

it('webrtc capability token not supported on sandbox')
    ->tap(fn () => config()->set('africastalking.username', 'sandbox'))
    ->throws(exception: \Exception::class, exceptionMessage: 'WebRTC not supported on Sandbox environment')
    ->expect(
        fn () => africastalking()->voice()->webrtc()->send()
    );

it('requests a webrtc capability token', function (): void {
    config()->set('africastalking.username', 'not_sandbox');

    Saloon::fake([
        MockResponse::make([
            'clientName' => 'John.Doe',
            'incoming' => true,
            'lifeTimeSec' => '86400',
            'outgoing' => true,
            'token' => 'ATCAPtkn_somerandomtexthere',
        ], 200),
    ]);

    $response = africastalking()->voice()
        ->webrtc()
        ->send();

    expect($response)
        ->toBeInstanceOf(CapabilityToken::class)
        ->clientName->toBe('John.Doe')
        ->incoming->toBeTrue()
        ->outgoing->toBeTrue()
        ->lifeTimeSec->toBe('86400')
        ->token->toBe('ATCAPtkn_somerandomtexthere');
})->skip();

it('WebRTC token has a token alias for send', function (): void {
    config()->set('africastalking.username', 'not_sandbox');

    Saloon::fake([
        MockResponse::make([
            'clientName' => 'John.Doe',
            'incoming' => true,
            'lifeTimeSec' => '86400',
            'outgoing' => true,
            'token' => 'ATCAPtkn_somerandomtexthere',
        ], 200),
    ]);

    $response = africastalking()->voice()
        ->webrtc()
        ->token();

    expect($response)
        ->toBeInstanceOf(CapabilityToken::class)
        ->clientName->toBe('John.Doe')
        ->incoming->toBeTrue()
        ->outgoing->toBeTrue()
        ->lifeTimeSec->toBe('86400')
        ->token->toBe('ATCAPtkn_somerandomtexthere');
})->skip();
