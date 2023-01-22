<?php

declare(strict_types=1);


use Illuminate\Support\Benchmark;
use SamuelMwangiW\Africastalking\Enum\Service;
use SamuelMwangiW\Africastalking\Saloon\AfricastalkingConnector;
use SamuelMwangiW\Africastalking\Saloon\Requests\Messaging\BulkSmsRequest;

test('benchmark pooling requests', function (string $phone): void {
    $messages = collect(fake()->sentences(200));

    $defaultWithSingleton = Benchmark::measure(
        benchmarkables: fn () => $messages->each(
            fn (string $message) => africastalking()->sms($message)->to($phone)->send()
        )
    );

    $pool = Benchmark::measure(function () use ($phone, $messages): void {
        $requests = [];

        $messages->each(function (string $message) use ($phone, &$requests): void {
            $data = [
                'message' => $message,
                'to' => $phone,
                'from' => config(key: 'africastalking.from'),
            ];

            $requests[] = BulkSmsRequest::make($data);
        });

        $connector = AfricastalkingConnector::make();
        $connector->service(Service::BULK_SMS);
        $pool = $connector->pool($requests, 10);

        $promise = $pool->send();
        $promise->wait();
    });

    $sameConnector = Benchmark::measure(function () use ($phone, $messages): void {
        $connector = AfricastalkingConnector::make()->service(Service::BULK_SMS);

        $messages->each(function (string $message) use ($connector, $phone): void {
            $data = [
                'message' => $message,
                'to' => $phone,
                'from' => config(key: 'africastalking.from'),
            ];

            $connector->send(BulkSmsRequest::make($data));
        });
    });

    dd($pool, $sameConnector, $defaultWithSingleton);
})->with('phone-numbers')->skip();
