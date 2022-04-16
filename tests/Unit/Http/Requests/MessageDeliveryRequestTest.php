<?php


use Illuminate\Support\Facades\Validator;
use SamuelMwangiW\Africastalking\Enum\Network;
use SamuelMwangiW\Africastalking\Http\Requests\MessageDeliveryRequest;

it('validates request', function (string $status, string $reason, array $data) {
    $request = new MessageDeliveryRequest();

    $data = array_merge(
        ['status' => $status],
        ['failureReason' => $reason],
        $data
    );

    $validator = Validator::make($data, $request->rules());

    expect($validator)
        ->passes()->toBeTrue();
})->with('status-values', 'failure-reason-values', 'sms-delivery-report-notification');

it('retrieves request data', function (string $status, string $reason, string $network, array $data) {
    $data = array_merge(
        ['status' => $status],
        ['failureReason' => $reason],
        ['networkCode' => $network],
        $data
    );

    $request = new MessageDeliveryRequest(request:$data);

    expect($request)
        ->id()->not->toBeNull()->toBe(data_get($data, 'id'))
        ->status()->not->toBeNull()->toBe(data_get($data, 'status'))
        ->network()->not->toBeNull()->toBeInstanceOf(Network::class)
        ->deliveryFailed()->toBeBool()
        ->phone()->not->toBeNull()->toBe(data_get($data, 'phoneNumber'));
})->with('status-values', 'failure-reason-values', 'network-codes', 'sms-delivery-report-notification');
