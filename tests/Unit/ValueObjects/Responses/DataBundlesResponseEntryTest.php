<?php

declare(strict_types=1);

use SamuelMwangiW\Africastalking\Enum\Status;
use SamuelMwangiW\Africastalking\ValueObjects\DataBundlesResponseEntry;
use SamuelMwangiW\Africastalking\ValueObjects\Money;
use SamuelMwangiW\Africastalking\ValueObjects\PhoneNumber;

it('can be instantiated', function (): void {
    $subject = new DataBundlesResponseEntry(
        number: PhoneNumber::make('+254722000000'),
        provider: 'provider',
        status: Status::SUCCESS,
        transactionId: 'transactionId',
        value: Money::make('USD 1'),
    );

    expect($subject)
        ->toBeInstanceOf(DataBundlesResponseEntry::class)
        ->and((string) $subject)->toBe($subject->__toString())
        ->and($subject->__toArray())
        ->toBeArray()
        ->toBe([
            'phoneNumber' => '+254722000000',
            'provider' => 'provider',
            'status' => 'Success',
            'transactionId' => 'transactionId',
            'value' => 'USD 1',
            'error' => null,
        ]);
});
