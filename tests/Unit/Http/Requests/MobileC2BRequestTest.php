<?php

declare(strict_types=1);

use Illuminate\Support\Facades\Validator;
use SamuelMwangiW\Africastalking\Http\Requests\MobileC2BValidationRequest;

it('validates request', function (string $provider, array $data): void {
    $request = new MobileC2BValidationRequest();
    $validator = Validator::make(
        array_merge(['provider' => $provider], $data),
        $request->rules()
    );

    expect($validator)
        ->passes()->toBeTrue();
})->with('payment-providers', 'mobile-c2b-notification');

it('retrieves request data', function (string $provider, array $data): void {
    $data = array_merge(['provider' => $provider], $data);

    $request = new MobileC2BValidationRequest(request: $data);

    expect($request)
        ->phone()->toBe(data_get($data, 'phoneNumber'))
        ->get('provider')->toBe(data_get($data, 'provider'))
        ->get('clientAccount')->toBe(data_get($data, 'clientAccount'))
        ->get('productName')->toBe(data_get($data, 'productName'))
        ->get('value')->toBe(data_get($data, 'value'))
        ->get('providerMetadata')->toBe(data_get($data, 'providerMetadata'));
})->with('payment-providers', 'mobile-c2b-notification');
