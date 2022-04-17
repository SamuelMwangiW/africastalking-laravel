<?php

use Illuminate\Support\Facades\Validator;
use SamuelMwangiW\Africastalking\Enum\UpdateType;
use SamuelMwangiW\Africastalking\Http\Requests\SubscriptionRequest;

it('validates request', function (array $data) {
    $request = new SubscriptionRequest();

    $validator = Validator::make($data, $request->rules());

    expect($validator)
        ->passes()->toBeTrue();
})->with('subscription-notification');

it('retrieves request data', function (array $data) {
    $request = new SubscriptionRequest(request: $data);

    expect($request)
        ->phone()->toBe(data_get($data, 'phoneNumber'))
        ->type()->toBeInstanceOf(UpdateType::class)
        ->type()->value->toBe(data_get($data, 'updateType'))
        ->get('shortCode')->toBe(data_get($data, 'shortCode'))
        ->get('keyword')->toBe(data_get($data, 'keyword'));
})->with('subscription-notification');
