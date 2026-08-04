<?php

declare(strict_types=1);

use GuzzleHttp\Promise\PromiseInterface;
use Saloon\Http\Faking\MockResponse;
use Saloon\Http\PendingRequest;
use Saloon\Laravel\Facades\Saloon;
use SamuelMwangiW\Africastalking\Exceptions\AfricastalkingException;
use SamuelMwangiW\Africastalking\Facades\Africastalking;
use SamuelMwangiW\Africastalking\Saloon\AfricastalkingConnector;
use SamuelMwangiW\Africastalking\Saloon\Requests\Messaging\BulkSmsRequest;
use SamuelMwangiW\Africastalking\Saloon\Requests\Messaging\PremiumSmsRequest;
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

it('resolves the correct base url for concurrent async sends to different services', function (): void {
    // The service provider only binds AfricastalkingConnector as a
    // container singleton outside of tests (App::runningUnitTests() is
    // true here), so a reused-connector bug wouldn't surface via app()
    // resolution in this environment. Bind it explicitly to reproduce the
    // production condition this test guards against.
    app()->singleton(AfricastalkingConnector::class, fn() => new AfricastalkingConnector());

    // Bulk and Premium share a base URL in sandbox mode, which would mask a
    // base-url mixup. Switch to a live username so they diverge.
    config(['africastalking.username' => 'liveuser']);

    $resolvedUrls = [];

    Saloon::fake([
        BulkSmsRequest::class => function (PendingRequest $pendingRequest) use (&$resolvedUrls) {
            $resolvedUrls['bulk'] = $pendingRequest->getUrl();

            return MockResponse::fixture('messaging/bulk/with-sender');
        },
        PremiumSmsRequest::class => function (PendingRequest $pendingRequest) use (&$resolvedUrls) {
            $resolvedUrls['premium'] = $pendingRequest->getUrl();

            return MockResponse::fixture('messaging/premium/send');
        },
    ]);

    // Both sendAsync() calls happen here, before either promise is waited
    // on — this is the exact interleaving a shared/reused connector would
    // race on, since Saloon only resolves each request's base URL once its
    // deferred task actually runs.
    $bulkPromise = Africastalking::sms('Hi Alice')->to('+254700072929')->async()->send();
    $premiumPromise = Africastalking::sms('Hi Bob')
        ->to('+254700072929')
        ->premium()
        ->as(config('africastalking.premium-shortcode'))
        ->async()
        ->send();

    $bulkPromise->wait();
    $premiumPromise->wait();

    expect($resolvedUrls['bulk'])->toStartWith('https://api.africastalking.com/')
        ->and($resolvedUrls['premium'])->toStartWith('https://content.africastalking.com/');
});
