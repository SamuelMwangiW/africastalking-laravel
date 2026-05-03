<?php

declare(strict_types=1);

use SamuelMwangiW\Africastalking\ValueObjects\PhoneNumber;
use SamuelMwangiW\Africastalking\ValueObjects\VoiceCallDTO;

it('can be instantiated', function (): void {
    $subject = new VoiceCallDTO(
        from: PhoneNumber::make('+254722000000'),
        to: $to = collect([PhoneNumber::make('+254722000000')]),
        clientRequestId: 'clientRequestId',
    );

    expect($subject)
        ->toBeInstanceOf(VoiceCallDTO::class)
        ->__toArray()->toBe([
            'from' => '+254722000000',
            'requestId' => 'clientRequestId',
            'to' => [$to->first()->number],
        ])
        ->and((string) $subject)->toBe($subject->__toString());
});
