<?php

declare(strict_types=1);

use Illuminate\Support\Facades\Validator;
use SamuelMwangiW\Africastalking\Enum\Network;
use SamuelMwangiW\Africastalking\Http\Requests\IncomingMessageRequest;

it('validates request', function (int $networkCode, array $data): void {
    $request = new IncomingMessageRequest();

    $validator = Validator::make(
        array_merge(
            $data,
            ['networkCode' => $networkCode]
        ),
        $request->rules()
    );

    expect($validator)
        ->passes()->toBeTrue();
})->with('network-codes', 'incoming-message-notification');


it('retrieves request data', function (int $networkCode, array $data): void {
    $request = new IncomingMessageRequest(
        request: array_merge(
            $data,
            ['networkCode' => $networkCode]
        )
    );

    expect($request)
        ->id()->not->toBeNull()->toBe(data_get($data, 'id'))
        ->phone()->not->toBeNull()->toBe(data_get($data, 'from'))
        ->network()->toBeInstanceOf(Network::class)
        ->network()->value->toEqual($networkCode)
        ->linkId()->toBe(data_get($data, 'linkId'))
        ->get('text')->toBe(data_get($data, 'text'))
        ->recipient()->toBe(data_get($data, 'to'));
})->with('network-codes', 'incoming-message-notification');
