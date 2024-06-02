<?php

declare(strict_types=1);

use Illuminate\Support\Facades\Validator;
use SamuelMwangiW\Africastalking\Enum\Network;
use SamuelMwangiW\Africastalking\Http\Requests\UssdSessionRequest;

it('validates request', function (int $networkCode, array $data): void {
    $request = new UssdSessionRequest();

    $validator = Validator::make(
        array_merge(
            $data,
            ['networkCode' => $networkCode],
        ),
        $request->rules(),
    );

    expect($validator)->passes()->toBeTrue();
})->with('network-codes', 'ussd-session-notification');

it('retrieves request data', function (int $networkCode, array $data): void {
    $request = new UssdSessionRequest(
        request: array_merge(
            $data,
            ['networkCode' => $networkCode],
        ),
    );

    expect($request)
        ->id()->not->toBeNull()->toBe(data_get($data, 'sessionId'))
        ->phone()->not->toBeNull()->toBe(data_get($data, 'phoneNumber'))
        ->network()->toBeInstanceOf(Network::class)
        ->network()->value->toEqual($networkCode)
        ->userInput()->toBe(data_get($data, 'text'))
        ->get('serviceCode')->toBe(data_get($data, 'serviceCode'));
})->with('network-codes', 'ussd-session-notification');
