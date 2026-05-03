<?php

declare(strict_types=1);

use SamuelMwangiW\Africastalking\Contracts\DTOContract;
use SamuelMwangiW\Africastalking\ValueObjects\AirtimeResponse;

expect(AirtimeResponse::class)
    ->toImplement(DTOContract::class);

it('can be constructed', function (): void {
    $object = new AirtimeResponse(
        errorMessage: 'error',
        amount: 'KES 1.00',
        discount: 'KES 0.00',
        numSent: 1,
        responses: collect([]),
    );

    expect($object)
        ->toBeInstanceOf(AirtimeResponse::class)
        ->hasDuplicate()->toBeFalse()
        ->and((string) $object)->toBe($object->__toString());
});

it('checks if the response flagged a duplicate', function (): void {
    $object = new AirtimeResponse(
        errorMessage: 'A duplicate request was received within the last 5 minutes',
        amount: 'KES 100.00',
        discount: 'KES 4.00',
        numSent: 1,
        responses: collect([]),
    );

    expect($object)
        ->toBeInstanceOf(AirtimeResponse::class)
        ->hasDuplicate()->toBeTrue();
});
