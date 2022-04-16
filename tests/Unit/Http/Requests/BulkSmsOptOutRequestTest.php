<?php

use Illuminate\Support\Facades\Validator;
use SamuelMwangiW\Africastalking\Http\Requests\BulkSmsOptOutRequest;

it('validates request', function (array $data) {
    $request = new BulkSmsOptOutRequest();

    $validator = Validator::make($data, $request->rules());

    expect($validator)
        ->passes()->toBeTrue();
})->with('bulk-sms-opt-out-notification');

it('retrieves request data', function (array $data) {
    $request = new BulkSmsOptOutRequest(request:$data);

    expect($request)
        ->id()->not->toBeNull()->toBe(data_get($data, 'senderId'))
        ->phone()->not->toBeNull()->toBe(data_get($data, 'phoneNumber'));
})->with('bulk-sms-opt-out-notification');
