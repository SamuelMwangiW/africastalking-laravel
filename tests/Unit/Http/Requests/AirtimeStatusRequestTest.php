<?php

use Illuminate\Support\Facades\Validator;
use SamuelMwangiW\Africastalking\Http\Requests\AirtimeStatusRequest;

it('validates request', function (array $data, string $status) {
    $request = new AirtimeStatusRequest();

    $validator = Validator::make(
        array_merge($data, ['status' => $status]),
        $request->rules()
    );

    expect($validator)
        ->passes()->toBeTrue();
})->with('airtime-status-notification', 'status-values');

it('retrieves request data', function (array $data) {
    $request = new AirtimeStatusRequest(request:$data);

    expect($request)
        ->id()->not->toBeNull()->toBe(data_get($data, 'requestId'))
        ->value()->not->toBeNull()->toBe(data_get($data, 'value'))
        ->discount()->not->toBeNull()->toBe(data_get($data, 'discount'))
        ->phone()->not->toBeNull()->toBe(data_get($data, 'phoneNumber'));
})->with('airtime-status-notification', 'status-values');
