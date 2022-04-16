<?php

use Illuminate\Support\Facades\Validator;
use SamuelMwangiW\Africastalking\Http\Requests\UssdEventRequest;

it('validates request', function (string $networkCode, string $status, array $data) {
    $request = new UssdEventRequest();

    $validator = Validator::make(
        array_merge(
            $data,
            ['networkCode' => $networkCode,'status' => $status]
        ),
        $request->rules()
    );

    expect($validator)
        ->passes()->toBeTrue();
})->with('network-codes', 'status-values', 'ussd-notification');

//it('retrieves request data', function (array $data) {
//    $request = new BulkSmsOptOutRequest(request:$data);
//
//    expect($request)
//        ->id()->not->toBeNull()->toBe(data_get($data, 'senderId'))
//        ->phone()->not->toBeNull()->toBe(data_get($data, 'phoneNumber'));
//})->with('bulk-sms-opt-out-notification');
