<?php

declare(strict_types=1);

use SamuelMwangiW\Africastalking\Contracts\DTOContract;
use SamuelMwangiW\Africastalking\Enum\Status;
use SamuelMwangiW\Africastalking\ValueObjects\Money;
use SamuelMwangiW\Africastalking\ValueObjects\Responses\InsightsResponse;

expect(InsightsResponse::class)
    ->toImplement(DTOContract::class);

it('can be converted to array or string', function (): void {
    $object = new InsightsResponse(
        items: collect([]),
        status: Status::QUEUED,
        cost: Money::make('KES 10'),
        id: 'id',
    );

    expect($object)
        ->toBeInstanceOf(InsightsResponse::class)
        ->status->toBe(Status::QUEUED)
        ->cost->toBeInstanceOf(Money::class)
        ->cost->amount->toBe(10.0)
        ->id->toBe('id')
        ->and((string) $object)
        ->toBe($object->__toString())
        ->and($object->__toArray())
        ->toBeArray();
});
