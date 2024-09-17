<?php

declare(strict_types=1);

use Illuminate\Support\Facades\Validator;
use SamuelMwangiW\Africastalking\Http\Requests\AirtimeValidationRequest;

it('validates request', function (array $data): void {
    $request = new AirtimeValidationRequest();

    $validator = Validator::make($data, $request->rules());

    expect($validator)
        ->passes()->toBeTrue();
})->with('airtime-validation-notification');

it('retrieves request data', function (array $data): void {
    $request = new AirtimeValidationRequest(request: $data);

    expect($request)
        ->id()->not->toBeNull()->toBe(data_get($data, 'transactionId'))
        ->sourceIp()->not->toBeNull()->toBe(data_get($data, 'sourceIpAddress'))
        ->amount()->not->toBeNull()->toBe(floatval(data_get($data, 'amount')))
        ->currencyCode()->not->toBeNull()->toBe(data_get($data, 'currencyCode'))
        ->phone()->not->toBeNull()->toBe(data_get($data, 'phoneNumber'));
})->with('airtime-validation-notification');
