<?php

declare(strict_types=1);

use GuzzleHttp\Promise\PromiseInterface;
use Saloon\Http\Faking\MockResponse;
use Saloon\Laravel\Facades\Saloon;
use SamuelMwangiW\Africastalking\Exceptions\AfricastalkingException;
use SamuelMwangiW\Africastalking\Facades\Africastalking;
use SamuelMwangiW\Africastalking\Saloon\Requests\Messaging\BulkSmsRequest;
use SamuelMwangiW\Africastalking\ValueObjects\SentMessageResponse;

it('sends synchronously by default', function (): void {
    Saloon::fake([
        BulkSmsRequest::class => MockResponse::fixture('messaging/bulk/with-sender'),
    ]);

    $response = Africastalking::sms('Hello there')->to('+254700072929')->send();

    expect($response)->toBeInstanceOf(SentMessageResponse::class);
});

it('returns a promise when sent asynchronously', function (): void {
    Saloon::fake([
        BulkSmsRequest::class => MockResponse::fixture('messaging/bulk/with-sender'),
    ]);

    $promise = Africastalking::sms('Hello there')
        ->to('+254700072929')
        ->async()
        ->send();

    expect($promise)->toBeInstanceOf(PromiseInterface::class);

    $response = $promise->wait();

    expect($response)->toBeInstanceOf(SentMessageResponse::class)
        ->recipients->toHaveCount(1);
});

it('rejects the promise when the async send fails', function (): void {
    Saloon::fake([
        BulkSmsRequest::class => MockResponse::fixture('messaging/bulk/invalid-sender-id'),
    ]);

    $promise = Africastalking::sms('Hello there')
        ->to('+254700072929')
        ->as('INVALID_SENDER')
        ->async()
        ->send();

    $promise->wait();
})->throws(AfricastalkingException::class, 'InvalidSenderId');
