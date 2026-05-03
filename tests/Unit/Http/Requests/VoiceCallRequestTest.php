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
    $request = new VoiceCallRequest(
        request: $data,
        server: ['REQUEST_METHOD' => 'POST'],
    );

    $isActive = in_array(
        data_get($data, 'isActive'),
        [true, 1],
        true,
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
        ->input('callStartTime')->toBe(data_get($data, 'callStartTime'))
        ->callIsActive()->toBe($isActive)
        ->callIsInActive()->not()->toBe($isActive)
        ->isWebrtcCall()->toBeFalse()
        ->isRinging()->toBeFalse()
        ->isSipAgentCall()->toBeFalse();
})->with('incoming-voice-call-notification');
