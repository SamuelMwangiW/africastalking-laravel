<?php

declare(strict_types=1);

use Illuminate\Support\Collection;
use Saloon\Http\Faking\MockResponse;
use Saloon\Http\PendingRequest;
use Saloon\Laravel\Facades\Saloon;
use SamuelMwangiW\Africastalking\Exceptions\AfricastalkingException;
use SamuelMwangiW\Africastalking\Facades\Africastalking;
use SamuelMwangiW\Africastalking\Saloon\Requests\Messaging\BulkSmsRequest;
use SamuelMwangiW\Africastalking\Saloon\Requests\Messaging\PremiumSmsRequest;
use SamuelMwangiW\Africastalking\ValueObjects\SentMessageResponse;

it('sends many messages concurrently and keys results by input order', function (): void {
    Saloon::fake([
        BulkSmsRequest::class => function (PendingRequest $pendingRequest): MockResponse {
            $to = (string) $pendingRequest->body()?->get('to');

            return MockResponse::make([
                'SMSMessageData' => [
                    'Message' => 'Sent to 1/1',
                    'Recipients' => [[
                        'cost' => 'KES 0.8000',
                        'messageId' => "ATXid_{$to}",
                        'number' => $to,
                        'status' => 'Success',
                        'statusCode' => 102,
                    ]],
                ],
            ], 201);
        },
    ]);

    $messages = [
        Africastalking::sms('Hi Alice')->to('+254700000001'),
        Africastalking::sms('Hi Bob')->to('+254700000002'),
        Africastalking::sms('Hi Carol')->to('+254700000003'),
    ];

    $results = Africastalking::sms()->pool($messages, concurrency: 2);

    expect($results)->toBeInstanceOf(Collection::class)
        ->toHaveCount(3)
        ->and($results->keys()->all())->toBe([0, 1, 2]);

    expect($results->get(0))->toBeInstanceOf(SentMessageResponse::class)
        ->recipients->first()->number->number->toBe('+254700000001');
    expect($results->get(1))->toBeInstanceOf(SentMessageResponse::class)
        ->recipients->first()->number->number->toBe('+254700000002');
    expect($results->get(2))->toBeInstanceOf(SentMessageResponse::class)
        ->recipients->first()->number->number->toBe('+254700000003');
});

it('preserves string keys from the given iterable', function (): void {
    Saloon::fake([
        BulkSmsRequest::class => MockResponse::fixture('messaging/bulk/with-sender'),
    ]);

    $results = Africastalking::sms()->pool([
        'alice' => Africastalking::sms('Hi Alice')->to('+254700072929'),
        'bob' => Africastalking::sms('Hi Bob')->to('+254700072929'),
    ]);

    expect($results->keys()->all())->toBe(['alice', 'bob']);
});

it('collects a per-item exception instead of failing the whole pool', function (): void {
    Saloon::fake([
        BulkSmsRequest::class => function (PendingRequest $pendingRequest) {
            $to = (string) $pendingRequest->body()?->get('to');

            if ('+254700000404' === $to) {
                return MockResponse::fixture('messaging/bulk/invalid-sender-id');
            }

            return MockResponse::fixture('messaging/bulk/with-sender');
        },
    ]);

    $results = Africastalking::sms()->pool([
        Africastalking::sms('Hi Alice')->to('+254700072929'),
        Africastalking::sms('Hi Bad')->to('+254700000404'),
    ]);

    expect($results->get(0))->toBeInstanceOf(SentMessageResponse::class)
        ->and($results->get(1))->toBeInstanceOf(AfricastalkingException::class)
        ->getMessage()->toContain('InvalidSenderId');
});

it('collects a transport-level exception via the pool exceptionHandler', function (): void {
    Saloon::fake([
        BulkSmsRequest::class => function (PendingRequest $pendingRequest) {
            $to = (string) $pendingRequest->body()?->get('to');

            if ('+254700000500' === $to) {
                return MockResponse::make(status: 500)->throw(new Exception('Simulated connection failure'));
            }

            return MockResponse::fixture('messaging/bulk/with-sender');
        },
    ]);

    $results = Africastalking::sms()->pool([
        Africastalking::sms('Hi Alice')->to('+254700072929'),
        Africastalking::sms('Hi Bad')->to('+254700000500'),
    ]);

    expect($results->get(0))->toBeInstanceOf(SentMessageResponse::class)
        ->and($results->get(1))->toBeInstanceOf(Throwable::class)
        ->getMessage()->toContain('Simulated connection failure');
});

it('returns an empty collection for an empty pool', function (): void {
    expect(Africastalking::sms()->pool([]))->toBeInstanceOf(Collection::class)->toBeEmpty();
});

it('rejects pool items that are not Message instances', function (): void {
    Africastalking::sms()->pool(['not a message']);
})->throws(AfricastalkingException::class, 'must be an instance of');

it('rejects mixing bulk and premium messages in a single pool', function (): void {
    Africastalking::sms()->pool([
        Africastalking::sms('Hi Alice')->to('+254700072929'),
        Africastalking::sms('Hi Bob')->to('+254700072929')->premium(),
    ]);
})->throws(AfricastalkingException::class, 'cannot mix bulk and premium');

it('sends a pool of premium messages', function (): void {
    Saloon::fake([
        PremiumSmsRequest::class => MockResponse::fixture('messaging/premium/send'),
    ]);

    $results = Africastalking::sms()->pool([
        Africastalking::sms('Hi Alice')->to('+254700072929')->premium()->as(config('africastalking.premium-shortcode')),
        Africastalking::sms('Hi Bob')->to('+254700072929')->premium()->as(config('africastalking.premium-shortcode')),
    ]);

    expect($results)->toHaveCount(2)
        ->and($results->get(0))->toBeInstanceOf(SentMessageResponse::class)
        ->and($results->get(1))->toBeInstanceOf(SentMessageResponse::class);
});
