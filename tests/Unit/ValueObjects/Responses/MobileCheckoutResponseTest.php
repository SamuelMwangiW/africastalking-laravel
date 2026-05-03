<?php

declare(strict_types=1);

use SamuelMwangiW\Africastalking\ValueObjects\MobileCheckoutResponse;

it('can be constructed', function (): void {
    $subject = new MobileCheckoutResponse(
        id: 'id',
        description: 'description',
        providerChannel: 'Channel',
        status: 'status',
    );

    expect($subject)
        ->toBeInstanceOf(MobileCheckoutResponse::class)
        ->and((string) $subject)->toBe($subject->__toString())
        ->and((array) $subject)->toBe([
            'id' => 'id',
            'description' => 'description',
            'providerChannel' => 'Channel',
            'status' => 'status',
        ]);
});

it('can be constructed from array', function (): void {
    $data = [
        'transactionId' => $id = Illuminate\Support\Str::random(),
        'description' => 'description',
        'providerChannel' => 'Channel',
        'status' => 'Successful',
    ];

    $subject = MobileCheckoutResponse::make($data);

    expect($subject)
        ->toBeInstanceOf(MobileCheckoutResponse::class)
        ->id->toBe($id);
});

it('can hasDuplicate', function (string $status): void {
    $data = [
        'transactionId' => Illuminate\Support\Str::random(),
        'description' => 'description',
        'providerChannel' => 'Channel',
        'status' => $status,
    ];

    $subject = MobileCheckoutResponse::make($data);

    expect($subject)
        ->toBeInstanceOf(MobileCheckoutResponse::class)
        ->status->toBe($status)
        ->hasDuplicate()->toBe('DuplicateRequest' === $status);
})->with([
    'Successful',
    'Failed',
    'DuplicateRequest',
]);
