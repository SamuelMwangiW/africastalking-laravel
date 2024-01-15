<?php

declare(strict_types=1);

use SamuelMwangiW\Africastalking\Contracts\DTOContract;
use SamuelMwangiW\Africastalking\Enum\Status;
use SamuelMwangiW\Africastalking\ValueObjects\StashTopupResponse;

it('can be constructed')
    ->expect(fn() => new StashTopupResponse(
        id: 'id',
        status: Status::SENT,
        description: 'description'
    ))
    ->toBeInstanceOf(StashTopupResponse::class)
    ->id->toBe('id')
    ->description->toBe('description');

it('can be constructed statically')
    ->expect(fn() => StashTopupResponse::make(
        [
            'transactionId' => 'id',
            'status' => Status::SENT->value,
            'description' => 'description',
        ]
    ))
    ->toBeInstanceOf(StashTopupResponse::class)
    ->id->toBe('id')
    ->description->toBe('description');

it('implements DTO contract')
    ->expect(fn() => new StashTopupResponse(
        id: 'id',
        status: Status::SENT,
        description: 'description'
    ))
    ->toBeInstanceOf(DTOContract::class);

it('can be cast to array')
    ->expect(fn() => new StashTopupResponse(
        id: 'id',
        status: Status::SENT,
        description: 'description'
    ))
    ->__toArray()->toBeArray()->toMatchArray(['id' => 'id','description' => 'description']);

it('can be cast to string', function (): void {
    $object = new StashTopupResponse(
        id: 'id',
        status: Status::SENT,
        description: 'description'
    );

    expect((string) $object)
        ->toBeString()
        ->toBe($object->__toString())
        ->toBe('{"id":"id","status":"Sent","description":"description"}');
});
