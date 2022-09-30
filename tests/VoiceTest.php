<?php

use Illuminate\Contracts\Support\Responsable;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use SamuelMwangiW\Africastalking\Domain\Voice;
use SamuelMwangiW\Africastalking\Facades\Africastalking;
use SamuelMwangiW\Africastalking\Response\VoiceResponse;
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

it('can reject calls')
    ->expect(
        fn () => Africastalking::voice()
            ->play('We are closed at the moment, kindly call tomorrow')
            ->reject()
            ->getResponse()
    )->toBe(
        '<?xml version="1.0" encoding="UTF-8"?><Response><Play url="We are closed at the moment, kindly call tomorrow"/><Reject/></Response>'
    );

it('sets content-type to text/plain in the response', function () {
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

it('makes a call', function () {
    $response = africastalking()->voice()->call('+254711234567')->send();

    expect($response)
        ->toBeArray()
        ->toHaveKeys(['entries', 'errorMessage'])
        ->and($response['errorMessage'])->toBeIn(['None','Invalid callbackUrl: ','Invalid callerId: ']);
});
