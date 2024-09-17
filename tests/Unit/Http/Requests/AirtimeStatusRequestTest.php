<?php

declare(strict_types=1);

use Illuminate\Support\Facades\Validator;
use SamuelMwangiW\Africastalking\Enum\Status;
use SamuelMwangiW\Africastalking\Http\Requests\AirtimeStatusRequest;

it('validates request', function (array $data, string $status): void {
    $request = new AirtimeStatusRequest();

    $validator = Validator::make(
        array_merge($data, ['status' => $status]),
        $request->rules(),
    );

    expect($validator)
        ->passes()->toBeTrue();
})->with('airtime-status-notification', 'status-values');

it('retrieves request data', function (string $status, array $data): void {
    $data = array_merge($data, ['status' => $status]);

    $deliveryStatusIsFailed = in_array(needle: $status, haystack: ['Rejected', 'Failed']);

    $request = new AirtimeStatusRequest(request: $data);

    expect($request)
        ->id()->not->toBeNull()->toBe(data_get($data, 'requestId'))
        ->value()->not->toBeNull()->toBe(data_get($data, 'value'))
        ->discount()->not->toBeNull()->toBe(data_get($data, 'discount'))
        ->status()->not->toBeNull()->toBeInstanceOf(Status::class)
        ->status()->value->toBe(data_get($data, 'status'))
        ->deliveryFailed()->toBeBool()->toBe($deliveryStatusIsFailed)
        ->phone()->not->toBeNull()->toBe(data_get($data, 'phoneNumber'));
})->with('status-values', 'airtime-status-notification');
