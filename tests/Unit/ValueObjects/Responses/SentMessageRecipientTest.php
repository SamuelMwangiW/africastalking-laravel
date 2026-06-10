<?php

declare(strict_types=1);

use SamuelMwangiW\Africastalking\Enum\Status;
use SamuelMwangiW\Africastalking\ValueObjects\SentMessageRecipient;

it('can be constructed', function (): void {
    $subject = SentMessageRecipient::make([
        'messageId' => Illuminate\Support\Str::uuid()->toString(),
        'number' => '+254722000000',
        'statusCode' => 101,
        'cost' => 'KES 1.00',
        'status' => 'Success',
    ]);

    expect($subject)
        ->toBeInstanceOf(SentMessageRecipient::class)
        ->number->number->toBe('+254722000000')
        ->cost->toBe('KES 1.00')
        ->status->toBe(Status::SUCCESS);
});

test('statusMessage() helper function', function (int $statusCode, string $status): void {
    $subject = SentMessageRecipient::make([
        'messageId' => Illuminate\Support\Str::uuid()->toString(),
        'number' => '+254722000000',
        'statusCode' => $statusCode,
        'cost' => 'KES 1.00',
        'status' => 'Success',
    ]);

    expect($subject->statusMessage())->toBe($status);

})->with([
    [100, 'Processed'],
    [101, 'Sent'],
    [102, 'Queued'],
    [401, 'RiskHold'],
    [402, 'InvalidSenderId'],
    [403, 'InvalidPhoneNumber'],
    [404, 'UnsupportedNumberType'],
    [405, 'InsufficientBalance'],
    [406, 'UserInBlacklist'],
    [407, 'CouldNotRoute'],
    [409, 'DoNotDisturbRejection'],
    [500, 'InternalServerError'],
    [501, 'GatewayError'],
    [502, 'RejectedByGateway'],
]);
