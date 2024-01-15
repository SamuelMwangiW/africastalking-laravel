<?php

declare(strict_types=1);

use Illuminate\Support\Collection;
use SamuelMwangiW\Africastalking\Contracts\DTOContract;
use SamuelMwangiW\Africastalking\ValueObjects\Message;
use SamuelMwangiW\Africastalking\ValueObjects\PhoneNumber;

it('resolves the Message::class')
    ->expect(fn() => app(Message::class))->toBeInstanceOf(Message::class);

it('implements the DTO Contract')
    ->expect(fn() => app(Message::class))->toBeInstanceOf(DTOContract::class);

it('can be constructed', function (string $message): void {
    $subject = new Message();

    expect($subject)
        ->message->toBeNull()
        ->to->toBeNull()
        ->from->toBeNull();
})->with('strings');

it('can be constructed with parameters', function (string $message, string $phone): void {
    $to = collect(PhoneNumber::make($phone));
    $from = fake()->word();

    $subject = new Message(
        message: $message,
        to: $to,
        from: $from,
    );

    expect($subject)
        ->message->toBe($message)
        ->to->toHaveCount(1)
        ->to->toBe($to)
        ->from->toBe($from);
})->with('strings', 'phone-numbers');

it('can be set to enqueue', function (string $message): void {
    $subject = new Message();

    expect($subject->enqueue())
        ->enqueue->toBe(1);
})->with('strings');

it('can be set not to enqueue', function (): void {
    $subject = new Message();

    expect($subject->enqueue(false))
        ->enqueue->toBe(0)
        ->and($subject->enqueue(0))
        ->enqueue->toBe(0);
});

it('can set from', function (string $from): void {
    $subject = new Message();

    expect($subject->as($from))
        ->from->toBe($from);
})->with('strings');

it('can set the text', function (string $text): void {
    $subject = new Message();

    expect($subject->text($text))
        ->message->toBe($text);
})->with('strings');

it('can set the message', function (string $message): void {
    $subject = new Message();

    expect($subject->message($message))
        ->message->toBe($message);
})->with('strings');

it('can set the recipients from string', function (string $phone): void {
    $subject = new Message();

    expect($subject->to($phone))
        ->to->toBeInstanceOf(Collection::class)->toHaveCount(1)
        ->to->first()->toBeInstanceOf(PhoneNumber::class)
        ->to->first()->number->toBe($phone);
})->with('phone-numbers');

it('can set the recipients from array', function (string $phone): void {
    $subject = new Message();

    expect($subject->to([$phone]))
        ->to->toBeInstanceOf(Collection::class)->toHaveCount(1)
        ->to->first()->toBeInstanceOf(PhoneNumber::class)
        ->to->first()->number->toBe($phone);
})->with('phone-numbers');

it('can set the recipients from collection', function (string $phone): void {
    $subject = new Message();
    $phoneNumbers = collect([
        PhoneNumber::make($phone),
    ]);

    expect($subject->to($phoneNumbers))
        ->to->toBeInstanceOf(Collection::class)->toHaveCount(1)
        ->to->first()->toBeInstanceOf(PhoneNumber::class)
        ->to->first()->number->toBe($phone);
})->with('phone-numbers');

it('can set the message to be bulk', function (): void {
    $subject = new Message();

    expect($subject->bulk())
        ->isBulk->toBeTrue();
});

it('can set the message to be premium', function (): void {
    $subject = new Message();

    expect($subject->premium())
        ->isBulk->toBeFalse();
});

it('can set bulkMode directly', function (): void {
    $subject = new Message();

    expect($subject->bulkMode(1))
        ->bulkSMSMode->toBe(1)
        ->and($subject->bulkMode(0))->bulkSMSMode->toBe(0)
        ->and($subject->bulkMode(2))->bulkSMSMode->toBe(0);
});

it('can set keyword', function (string $word): void {
    $subject = new Message();

    expect($subject->keyword($word))->keyword->toBe($word);
})->with('strings');

it('can set linkId', function (string $word): void {
    $subject = new Message();

    expect($subject->linkId($word))->linkId->toBe($word);
})->with('strings');

it('can set retry', function (): void {
    $subject = new Message();
    $retry = fake()->randomNumber();

    expect($subject->retry($retry))->retryDurationInHours->toBe($retry);
});
