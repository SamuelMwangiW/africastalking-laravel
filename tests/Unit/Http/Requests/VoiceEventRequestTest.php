<?php

use Illuminate\Support\Facades\Validator;
use SamuelMwangiW\Africastalking\Http\Requests\VoiceEventRequest;

it('validates request', function (string $direction, array $data) {
    $request = new VoiceEventRequest();
    $validator = Validator::make(
        array_merge(['direction' => $direction], $data),
        $request->rules()
    );

    expect($validator)
       ->passes()->toBeTrue();
})->with('call-directions', 'voice-event-notification');

it('retrieves request data', function (array $data) {
    $request = new VoiceEventRequest(request: $data);

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
})->with('voice-event-notification');
