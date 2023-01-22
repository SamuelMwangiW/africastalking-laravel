<?php

declare(strict_types=1);


use Saloon\Http\Response;
use SamuelMwangiW\Africastalking\Saloon\AfricastalkingConnector;
use SamuelMwangiW\Africastalking\Saloon\Requests\Messaging\BulkSmsRequest;
use SamuelMwangiW\Africastalking\ValueObjects\SentMessageResponse;

test('benchmark pooling requests', function (string $phone): void {
    $messages = collect(fake()->sentences(100));

    $responses = collect([]);

    $requests = $messages->map(function (string $message) use ($phone): BulkSmsRequest {
        $data = [
            'message' => $message,
            'to' => $phone,
            'from' => config(key: 'africastalking.from'),
        ];

        return BulkSmsRequest::make($data);
    });

    $connector = AfricastalkingConnector::make()->service($requests->first()->service);
    $connector->pool(
        requests: $requests,
        concurrency: 10,
        responseHandler: fn(Response $data) => $responses->push($data->dto())
    )->send()->wait();

    expect($responses)
        ->not->toBeEmpty()
        ->toHaveCount(100)
        ->each->toBeInstanceOf(SentMessageResponse::class);
})->with('phone-numbers')->skip();
