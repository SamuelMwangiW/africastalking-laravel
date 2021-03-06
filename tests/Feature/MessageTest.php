<?php

use Illuminate\Support\Collection;
use SamuelMwangiW\Africastalking\Exceptions\AfricastalkingException;
use SamuelMwangiW\Africastalking\Facades\Africastalking;
use SamuelMwangiW\Africastalking\ValueObjects\PhoneNumber;
use SamuelMwangiW\Africastalking\ValueObjects\RecipientsApiResponse;

it('can send bulk message when from is not set', function (string $phone, string $message) {
    config()->set('africastalking.from', null);

    $response = Africastalking::sms($message)
        ->to($phone)
        ->send();

    expect($response)
        ->toBeInstanceOf(Collection::class)
        ->toHaveCount(1)
        ->first()->toBeInstanceOf(RecipientsApiResponse::class)
        ->first()->number->toBeInstanceOf(PhoneNumber::class)
        ->first()->number->number->toBe($phone);
})->with('phone-numbers', 'sentence');

it('can send bulk message', function (string $phone, string $message) {
    $response = Africastalking::sms($message)
        ->to($phone)
        ->send();

    expect($response)
        ->toBeInstanceOf(Collection::class)
        ->toHaveCount(1)
        ->first()->toBeInstanceOf(RecipientsApiResponse::class)
        ->first()->number->toBeInstanceOf(PhoneNumber::class)
        ->first()->number->number->toBe($phone);
})->with('phone-numbers', 'sentence');

it('can enqueue bulk message', function (string $phone, string $message) {
    $response = Africastalking::sms($message)
        ->to($phone)
        ->enqueue()
        ->send();

    expect($response)
        ->toBeInstanceOf(Collection::class)
        ->toHaveCount(1)
        ->first()->toBeInstanceOf(RecipientsApiResponse::class)
        ->first()->number->toBeInstanceOf(PhoneNumber::class)
        ->first()->number->number->toBe($phone);
})->with('phone-numbers', 'sentence');

it('can send message without enqueue', function (string $phone, string $message) {
    $response = Africastalking::sms($message)
        ->to($phone)
        ->enqueue(value: false)
        ->bulk()
        ->send();

    expect($response)
        ->toBeInstanceOf(Collection::class)
        ->toHaveCount(1)
        ->first()->toBeInstanceOf(RecipientsApiResponse::class)
        ->first()->number->toBeInstanceOf(PhoneNumber::class)
        ->first()->number->number->toBe($phone);
})->with('phone-numbers', 'sentence');

it('can change message senderID', function (string $phone, string $message) {
    $response = Africastalking::sms($message)
        ->to($phone)
        ->as(config('africastalking.from-backup'))
        ->send();

    expect($response)
        ->toBeInstanceOf(Collection::class)
        ->toHaveCount(1)
        ->first()->toBeInstanceOf(RecipientsApiResponse::class)
        ->first()->number->toBeInstanceOf(PhoneNumber::class)
        ->first()->number->number->toBe($phone);
})->with('phone-numbers', 'sentence');

it('thows an exception for an invalid request', function () {
    config()->set('africastalking.api-key', 'invalid-key-here');

    Africastalking::sms('This is a dummy message')
        ->to('+225 0574825420') //number throws invalid Phone Number
        ->send();
})->throws(\Exception::class);

it('can send premium messages', function (string $phone, string $message) {
    $response = Africastalking::sms($message)
        ->to($phone)
        ->premium()
        ->as(config('africastalking.premium-shortcode'))
        ->send();

    expect($response)
        ->toBeInstanceOf(Collection::class)
        ->toHaveCount(1)
        ->first()->toBeInstanceOf(RecipientsApiResponse::class)
        ->first()->cost->toBe('0');
})->with('phone-numbers', 'sentence');

it('can send premium messages in bulk mode', function (string $phone, string $message) {
    $response = Africastalking::sms($message)
        ->to($phone)
        ->premium()
        ->bulkMode()
        ->as(config('africastalking.premium-shortcode'))
        ->send();

    expect($response)
        ->toBeInstanceOf(Collection::class)
        ->toHaveCount(1)
        ->first()->toBeInstanceOf(RecipientsApiResponse::class)
        ->first()->cost->not->toBe('0');
})->with('phone-numbers', 'sentence');

it('can send premium messages with a keyword', function (string $phone, string $message) {
    $response = Africastalking::sms($message)
        ->to($phone)
        ->premium()
        ->keyword('keyword')
        ->as(config('africastalking.premium-shortcode'))
        ->send();

    expect($response)
        ->toBeInstanceOf(Collection::class)
        ->toHaveCount(1)
        ->first()->toBeInstanceOf(RecipientsApiResponse::class)
        ->first()->cost->toBe('0');
})->with('phone-numbers', 'sentence');

it('can send premium messages with a linkid', function (string $phone, string $message) {
    $response = Africastalking::sms($message)
        ->to($phone)
        ->premium()
        ->linkId('9641a050-41f3-457c-a273-f246d3d5ba80')
        ->as(config('africastalking.premium-shortcode'))
        ->send();

    expect($response)
        ->toBeInstanceOf(Collection::class)
        ->toHaveCount(1)
        ->first()->toBeInstanceOf(RecipientsApiResponse::class)
        ->first()->cost->toBe('0');
})->with('phone-numbers', 'sentence');

it('throws an exception for invalid sender id', function (string $phone) {
    $response = Africastalking::sms('test message')
        ->to($phone)
        ->as('INVALID_SENDER')
        ->send();
})->with('phone-numbers')
    ->throws(exception: AfricastalkingException::class, exceptionMessage: 'InvalidSenderId');
