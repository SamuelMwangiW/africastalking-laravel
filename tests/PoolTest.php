<?php

use Illuminate\Support\Benchmark;
use SamuelMwangiW\Africastalking\Enum\Service;
use SamuelMwangiW\Africastalking\Saloon\AfricastalkingConnector;
use SamuelMwangiW\Africastalking\Saloon\Requests\Messaging\BulkSmsRequest;

test('benchmark pooling requests', function (string $phone) {
    $messages = collect(fake()->sentences(600));

    // 4915.749416 ms
    $pool = Benchmark::measure(function () use ($phone, $messages) {
        $requests = [];

        $messages->each(function (string $message) use ($phone, &$requests) {
            $data = [
                'message' => $message,
                'to' => $phone,
                'from' => config(key:'africastalking.from')
            ];

            $requests[] = BulkSmsRequest::make($data);
        });

        $connector = AfricastalkingConnector::make();
        $connector->service(Service::BULK_SMS);
        $pool = $connector->pool($requests);
        $pool->setConcurrency(10);

        $promise = $pool->send();
        $promise->wait();
    });

    // 157157.544833 ms
//    $individually = Benchmark::measure(
//        fn() => $messages->each(
//            fn(string $message) => africastalking()->sms($message)->to($phone)->send()
//        )
//    );

    expect($pool)->toBeNumeric();
    dump($pool);
})->with('phone-numbers');
