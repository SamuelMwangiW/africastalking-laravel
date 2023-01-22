<?php

declare(strict_types=1);

use Illuminate\Support\Facades\Validator;
use SamuelMwangiW\Africastalking\Enum\Direction;
use SamuelMwangiW\Africastalking\Enum\PaymentCategory;
use SamuelMwangiW\Africastalking\Enum\PaymentProvider;
use SamuelMwangiW\Africastalking\Enum\PaymentSourceType;
use SamuelMwangiW\Africastalking\Enum\Status;
use SamuelMwangiW\Africastalking\Http\Requests\PaymentNotificationRequest;

it('validates request', function (string $provider, string $category, string $source, string $status, array $data): void {
    $request = new PaymentNotificationRequest();
    $data = array_merge(
        ['provider' => $provider, 'category' => $category, 'sourceType' => $source, 'destinationType' => $source, 'status' => $status],
        $data
    );

    $validator = Validator::make($data, $request->rules());

    expect($validator)
        ->passes()->toBeTrue();
})->with('payment-providers', 'payment-categories', 'payment-source-types', 'status-values', 'payment-notification');

it('retrieves request data', function (string $provider, string $category, string $source, string $status, array $data): void {
    $request = new PaymentNotificationRequest(
        request: array_merge(
            ['provider' => $provider, 'category' => $category, 'sourceType' => $source, 'destinationType' => $source, 'status' => $status],
            $data
        )
    );

    expect($request)
        ->category()->toBeInstanceOf(PaymentCategory::class)
        ->direction()->toBeInstanceOf(Direction::class)
        ->provider()->toBeInstanceOf(PaymentProvider::class)
        ->status()->toBeInstanceOf(Status::class)
        ->sourceType()->toBeInstanceOf(PaymentSourceType::class)
        ->amount()->toBeInt()->toBe(10000)
        ->id()->toBe(data_get($data, 'transactionId'))
        ->get('value')->toBe(data_get($data, 'value'));
})->with('payment-providers', 'payment-categories', 'payment-source-types', 'status-values', 'payment-notification');
