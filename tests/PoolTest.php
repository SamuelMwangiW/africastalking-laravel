<?php


use Illuminate\Support\Benchmark;
use SamuelMwangiW\Africastalking\Enum\Service;
use SamuelMwangiW\Africastalking\Saloon\AfricastalkingConnector;
use SamuelMwangiW\Africastalking\Saloon\Requests\Messaging\BulkSmsRequest;

test('benchmark pooling requests', function (string $phone) {
    $messages = collect(fake()->sentences(200));

    $pool = Benchmark::measure(function () use ($phone, $messages) {
        $requests = [];

        $messages->each(function (string $message) use ($phone, &$requests) {
            $data = [
                'message' => $message,
                'to' => $phone,
                'from' => config(key: 'africastalking.from')
            ];

            $requests[] = BulkSmsRequest::make($data);
        });

        $connector = AfricastalkingConnector::make();
        $connector->service(Service::BULK_SMS);
        $pool = $connector->pool($requests,10);

        $promise = $pool->send();
        $promise->wait();
    });

    $sameConnector = Benchmark::measure(function () use ($phone, $messages) {
        $connector = AfricastalkingConnector::make()->service(Service::BULK_SMS);

        $messages->each(function (string $message) use ($connector, $phone) {
            $data = [
                'message' => $message,
                'to' => $phone,
                'from' => config(key: 'africastalking.from')
            ];

            $connector->send(BulkSmsRequest::make($data));
        });
    });

    dd($pool, $sameConnector);
})->with('phone-numbers')->only();
