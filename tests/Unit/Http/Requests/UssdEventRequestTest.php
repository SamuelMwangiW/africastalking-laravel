<?php

declare(strict_types=1);

use Illuminate\Support\Facades\Validator;
use SamuelMwangiW\Africastalking\Enum\Network;
use SamuelMwangiW\Africastalking\Http\Requests\UssdEventRequest;

it('validates request', function (int $networkCode, string $status, array $data): void {
    $request = new UssdEventRequest();

    $validator = Validator::make(
        array_merge(
            $data,
            ['networkCode' => $networkCode, 'status' => $status]
        ),
        $request->rules()
    );

    expect($validator)
        ->passes()->toBeTrue();
})->with('network-codes', 'status-values', 'ussd-event-notification');

it('retrieves request data', function (int $networkCode, string $status, array $data): void {
    $request = new UssdEventRequest(
        request: array_merge(
            $data,
            ['networkCode' => $networkCode, 'status' => $status]
        )
    );

    expect($request)
        ->id()->not->toBeNull()->toBe(data_get($data, 'sessionId'))
        ->phone()->not->toBeNull()->toBe(data_get($data, 'phoneNumber'))
        ->network()->toBeInstanceOf(Network::class)
        ->network()->value->toEqual($networkCode)
        ->userInput()->toBe(data_get($data, 'input'))
        ->cost()->toEqual(data_get($data, 'cost'))
        ->hops()->toBeInt()->toBe(data_get($data, 'hopsCount'))
        ->duration()->not->toBeNull()->toBeInstanceOf(\Carbon\CarbonInterval::class)
        ->get('serviceCode')->toBe(data_get($data, 'serviceCode'))
        ->get('lastAppResponse')->toBe(data_get($data, 'lastAppResponse'));
})->with('network-codes', 'status-values', 'ussd-event-notification');
