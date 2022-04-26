<?php

use SamuelMwangiW\Africastalking\Transporter\Requests\AfricastalkingRequest;

it('throws an exception for any other method besides GET and POST', function () {
    class TestClass extends AfricastalkingRequest
    {
        protected string $method = 'PUT';
    }

    ;

    app(TestClass::class)->decorate();
})->expectException(OutOfBoundsException::class);


it('adds the username to data for POST requests', function () {
    class TestPostClass extends AfricastalkingRequest
    {
        protected string $method = 'POST';

        public function getData(): array
        {
            return $this->data;
        }
    }

    $request = app(TestPostClass::class)->decorate();

    expect($request)
        ->getData()->toBeArray()
        ->toBe(['username' => config('africastalking.username')]);
});

it('adds the username to query for GET requests', function () {
    class TestGetClass extends AfricastalkingRequest
    {
        protected string $method = 'GET';
    }

    $request = app(TestGetClass::class)->decorate();

    expect($request)
        ->getQuery()->toBeArray()
        ->toBe(['username' => config('africastalking.username')]);
});

it('adds the idempotency key to header', function () {
    class TestIdempotentClass extends AfricastalkingRequest
    {
    }

    $request = app(TestIdempotentClass::class)
        ->idempotent('unique-request-key-123')
        ->decorate()
        ->getRequest();

    expect($request)
        ->getOptions()->toBeArray()
        ->toHaveKey('headers');

    expect($request->getOptions()['headers'])
        ->toBeArray()
        ->toMatchArray(["Idempotency-Key" => "unique-request-key-123"]);
});
