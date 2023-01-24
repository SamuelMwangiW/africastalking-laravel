<?php

declare(strict_types=1);

use SamuelMwangiW\Africastalking\Exceptions\AfricastalkingException;
use SamuelMwangiW\Africastalking\Notifications\AfricastalkingChannel;
use SamuelMwangiW\Africastalking\Tests\Fixtures\BasicNotifiable;
use SamuelMwangiW\Africastalking\Tests\Fixtures\BasicNotifiableNoRoute;
use SamuelMwangiW\Africastalking\Tests\Fixtures\BasicNotifiableNoTrait;
use SamuelMwangiW\Africastalking\Tests\Fixtures\BasicNotificationNoToAfricastalking;
use SamuelMwangiW\Africastalking\Tests\Fixtures\BasicNotificationReturnsObject;
use SamuelMwangiW\Africastalking\Tests\Fixtures\BasicNotificationReturnsString;
use SamuelMwangiW\Africastalking\ValueObjects\SentMessageRecipient;
use SamuelMwangiW\Africastalking\ValueObjects\SentMessageResponse;

it('can resolve', function (): void {
    $channel = app(AfricastalkingChannel::class);

    expect($channel)->toBeInstanceOf(AfricastalkingChannel::class);
});

it('throws an exception when notifiable does not use trait', function (): void {
    $channel = app(AfricastalkingChannel::class);
    $notifiable = new BasicNotifiableNoTrait();
    $notification = new BasicNotificationReturnsString();

    $channel->send($notifiable, $notification);
})->throws(AfricastalkingException::class);

it('throws an exception when notifiable has routeNotificationForAfricastalking()', function (): void {
    $channel = app(AfricastalkingChannel::class);
    $notifiable = new BasicNotifiableNoRoute();
    $notification = new BasicNotificationReturnsString();

    $channel->send($notifiable, $notification);
})->throws(AfricastalkingException::class);

it('throws an exception when notification has toAfricastalking()', function (): void {
    $channel = app(AfricastalkingChannel::class);
    $notifiable = new BasicNotifiable();
    $notification = new BasicNotificationNoToAfricastalking();

    $channel->send($notifiable, $notification);
})->throws(AfricastalkingException::class);

it('sends a notification when toAfricastalking() returns string message', function (string $phone): void {
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
