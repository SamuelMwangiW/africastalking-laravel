<?php

declare(strict_types=1);

use Illuminate\Support\Facades\Validator;
use SamuelMwangiW\Africastalking\Http\Requests\VoiceCallRequest;

it('validates request', function (array $data): void {
    $request = new VoiceCallRequest();
    $validator = Validator::make($data, $request->rules());

    expect($validator)
        ->passes()->toBeTrue();
})->with('incoming-voice-call-notification');

it('retrieves request data', function (array $data): void {
    $request = new VoiceCallRequest(request: $data);

    expect($request)
        ->phone()->toBe(data_get($data, 'callerNumber'))
        ->id()->toBe(data_get($data, 'sessionId'))
        ->get('direction')->toBe(data_get($data, 'direction'))
        ->get('destinationNumber')->toBe(data_get($data, 'destinationNumber'))
        ->get('dtmfDigits')->toBe(data_get($data, 'dtmfDigits'))
        ->get('callSessionState')->toBe(data_get($data, 'callSessionState'))
        ->get('callerCarrierName')->toBe(data_get($data, 'callerCarrierName'))
        ->get('callerCountryCode')->toBe(data_get($data, 'callerCountryCode'))
        ->get('callStartTime')->toBe(data_get($data, 'callStartTime'));
})->with('incoming-voice-call-notification');
