<?php

use Illuminate\Http\Request;
use Illuminate\Http\Response;
use SamuelMwangiW\Africastalking\Facades\Africastalking;
use SamuelMwangiW\Africastalking\Response\UssdResponse;
use Symfony\Component\HttpFoundation\ResponseHeaderBag;

it('resolves the application class')
    ->expect(fn () => Africastalking::ussd())
    ->toBeInstanceOf(UssdResponse::class);

it('can pass the response message while resolving')
    ->expect(fn () => Africastalking::ussd('Message here'))
    ->toBeInstanceOf(UssdResponse::class)
    ->getResponse()->toBe('CON Message here');

it('can pass the response type while resolving')
    ->expect(fn () => Africastalking::ussd(response: 'Message here', expectsInput: false))
    ->toBeInstanceOf(UssdResponse::class)
    ->getResponse()->toBe('END Message here');

it('sets a default response if no message is set')
    ->expect(fn () => Africastalking::ussd())
    ->toBeInstanceOf(UssdResponse::class)
    ->getResponse()->toBe('END Thank you!');

it('can set the response message fluently')
    ->expect(fn () => Africastalking::ussd()->response('Message here'))
    ->toBeInstanceOf(UssdResponse::class)
    ->getResponse()->toBe('CON Message here');

it('can set whether to expect user input fluently')
    ->expect(fn () => Africastalking::ussd('Message here')->expectsInput(false))
    ->toBeInstanceOf(UssdResponse::class)
    ->getResponse()->toBe('END Message here');

test('the default for expectsInput is true')
    ->expect(fn () => Africastalking::ussd('Message here')->expectsInput())
    ->toBeInstanceOf(UssdResponse::class)
    ->getResponse()->toBe('CON Message here');

test('end sets the response prefix to END')
    ->expect(fn () => Africastalking::ussd('Message here')->end())
    ->toBeInstanceOf(UssdResponse::class)
    ->getPrefix()->toBe('END ');

it('sets content-type to text/plain in the response', function () {
    $request = Request::create(uri: '/');

    $response = Africastalking::ussd('Message here')
        ->end()
        ->toResponse($request);

    expect($response)
        ->toBeInstanceOf(Response::class)
        ->headers->toBeInstanceOf(ResponseHeaderBag::class)
        ->headers->get('content-type')->toBe('text/plain');
});
