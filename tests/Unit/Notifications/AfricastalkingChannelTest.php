<?php

declare(strict_types=1);

use Illuminate\Support\Facades\Notification;
use Saloon\Http\Faking\MockResponse;
use Saloon\Laravel\Facades\Saloon;
use SamuelMwangiW\Africastalking\Enum\Status;
use SamuelMwangiW\Africastalking\Exceptions\AfricastalkingException;
use SamuelMwangiW\Africastalking\Notifications\AfricastalkingChannel;
use SamuelMwangiW\Africastalking\Saloon\Requests\Messaging\BulkSmsRequest;
use SamuelMwangiW\Africastalking\Tests\Fixtures\BasicNotifiable;
use SamuelMwangiW\Africastalking\Tests\Fixtures\BasicNotifiableNoTrait;
use SamuelMwangiW\Africastalking\Tests\Fixtures\BasicNotification;
use SamuelMwangiW\Africastalking\Tests\Fixtures\BasicNotificationNoToAfricastalking;
use SamuelMwangiW\Africastalking\Tests\Fixtures\BasicNotificationReturnsObject;
use SamuelMwangiW\Africastalking\Tests\Fixtures\BasicNotificationReturnsString;
use SamuelMwangiW\Africastalking\Tests\Fixtures\FakeChannel;
use SamuelMwangiW\Africastalking\ValueObjects\SentMessageRecipient;
use SamuelMwangiW\Africastalking\ValueObjects\SentMessageResponse;

it('can resolve', function (): void {
    $channel = app(AfricastalkingChannel::class);

    expect($channel)->toBeInstanceOf(AfricastalkingChannel::class);
});

it('does not throw an exception when notifiable does not use trait but implements ReceivesSmsMessages', function (): void {
    Saloon::fake([
        BulkSmsRequest::class => MockResponse::fixture('messaging/bulk/notification'),
    ]);

    $channel = app(AfricastalkingChannel::class);
    $notifiable = new BasicNotifiableNoTrait();
    $notification = new BasicNotificationReturnsString();

    $channel->send($notifiable, $notification);
})->throwsNoExceptions();

it('throws an exception when notification has toAfricastalking()', function (): void {
    $channel = app(AfricastalkingChannel::class);
    $notifiable = new BasicNotifiable();
    $notification = new BasicNotificationNoToAfricastalking();

    $channel->send($notifiable, $notification);
})->throws(AfricastalkingException::class);

it('sends a notification when toAfricastalking() returns string message', function (string $phone): void {
    Saloon::fake([
        BulkSmsRequest::class => MockResponse::fixture('messaging/bulk/notification'),
    ]);

    $channel = app(AfricastalkingChannel::class);
    $notifiable = new BasicNotifiable(phone: $phone);
    $notification = new BasicNotificationReturnsString();

    $results = $channel->send($notifiable, $notification);

    expect($results)
        ->toBeInstanceOf(SentMessageResponse::class)
        ->recipients->toHaveCount(1)
        ->and($results->recipients->first())
        ->toBeInstanceOf(SentMessageRecipient::class)
        ->number->number->toBe($phone);
})->with('phone-numbers');

it('sends a notification when toAfricastalking() returns a message object', function (string $phone): void {
    Saloon::fake([
        BulkSmsRequest::class => MockResponse::fixture('messaging/bulk/notification'),
    ]);

    $channel = app(AfricastalkingChannel::class);
    $notifiable = new BasicNotifiable(phone: $phone);
    $notification = new BasicNotificationReturnsObject();

    $results = $channel->send($notifiable, $notification);

    expect($results)
        ->toBeInstanceOf(SentMessageResponse::class)
        ->recipients->toHaveCount(1)
        ->and($results->recipients->first())
        ->toBeInstanceOf(SentMessageRecipient::class)
        ->number->number->toBe($phone);
})->with('phone-numbers');

it('supports AnonymousNotifiable', function (string $phone): void {
    Saloon::fake([
        BulkSmsRequest::class => MockResponse::fixture('messaging/bulk/on-demand'),
    ]);

    $this->swap(AfricastalkingChannel::class, $fake = new FakeChannel());

    Notification::route(AfricastalkingChannel::class, $phone)
        ->notify(new BasicNotification(message: 'Sample SMS'));

    expect($fake->results)
        ->toBeInstanceOf(SentMessageResponse::class)
        ->recipients->toHaveCount(1)
        ->and($fake->results->recipients->first())
        ->toBeInstanceOf(SentMessageRecipient::class)
        ->statusCode->toBe(102)
        ->status->toBe(Status::SUCCESS)
        ->number->number->toBe($phone);
})->with('phone-numbers')->issue(13);
