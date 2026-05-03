<?php

declare(strict_types=1);

use Illuminate\Support\Facades\Validator;
use SamuelMwangiW\Africastalking\Http\Requests\VoiceEventRequest;

it('validates request', function (string $direction, array $data): void {
    $request = new VoiceEventRequest();
    $validator = Validator::make(
        array_merge(['direction' => $direction], $data),
        $request->rules(),
    );

    expect($validator)
        ->passes()->toBeTrue();
})->with('call-directions', 'voice-event-notification');

it('retrieves request data', function (array $data): void {
    $request = new VoiceEventRequest(
        request: $data,
        server: ['REQUEST_METHOD' => 'POST'],
    );

    expect($request)
        ->phone()->toBe(data_get($data, 'callerNumber'))
        ->id()->toBe(data_get($data, 'sessionId'))
        ->input('direction')->toBe(data_get($data, 'direction'))
        ->input('destinationNumber')->toBe(data_get($data, 'destinationNumber'))
        ->input('dtmfDigits')->toBe(data_get($data, 'dtmfDigits'))
        ->input('callSessionState')->toBe(data_get($data, 'callSessionState'))
        ->input('callerCarrierName')->toBe(data_get($data, 'callerCarrierName'))
        ->input('callerCountryCode')->toBe(data_get($data, 'callerCountryCode'))
        ->input('callStartTime')->toBe(data_get($data, 'callStartTime'));
})->with('voice-event-notification');
