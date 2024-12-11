<?php

declare(strict_types=1);

use SamuelMwangiW\Africastalking\Contracts\DTOContract;
use SamuelMwangiW\Africastalking\Enum\Status;
use SamuelMwangiW\Africastalking\ValueObjects\Money;
use SamuelMwangiW\Africastalking\ValueObjects\PhoneNumber;
use SamuelMwangiW\Africastalking\ValueObjects\Responses\InsightsResponseItem;

expect(InsightsResponseItem::class)
    ->toImplement(DTOContract::class);

it('can be constructed', function (): void {
    $object = new InsightsResponseItem(
        id: 'id',
        phoneNumber: PhoneNumber::make('+254722000000'),
        status: Status::QUEUED,
        cost: Money::make('USD 1'),
    );

    expect($object)
        ->toBeInstanceOf(InsightsResponseItem::class)
        ->id->toBe('id')
        ->phoneNumber->number->toBe('+254722000000')
        ->status->toBe(Status::QUEUED)
        ->cost->amount->toBe(1.0)
        ->and((string) $object)->toBe($object->__toString())
        ->and($object->__toArray())->toBeArray();
});
