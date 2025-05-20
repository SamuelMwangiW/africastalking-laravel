<?php

declare(strict_types=1);

namespace SamuelMwangiW\Africastalking\ValueObjects;

use SamuelMwangiW\Africastalking\Contracts\DTOContract;
use SamuelMwangiW\Africastalking\Enum\Status;

class AirtimeRecipientResponse implements DTOContract
{
    public function __construct(
        public readonly PhoneNumber $phoneNumber,
        public readonly string $errorMessage,
        public readonly string $amount,
        public readonly Status $status,
        public readonly string $requestId,
        public readonly string $discount,
    ) {}

    public function __toString(): string
    {
        return (string) json_encode($this);
    }

    public function __toArray(): array
    {
        return [];
    }

    public static function make(array $response): AirtimeRecipientResponse
    {
        return new AirtimeRecipientResponse(
            phoneNumber: PhoneNumber::make(data_get($response, 'phoneNumber')),
            errorMessage: data_get($response, 'errorMessage'),
            amount: data_get($response, 'amount'),
            status: Status::from(data_get($response, 'status')),
            requestId: data_get($response, 'requestId'),
            discount: data_get($response, 'discount'),
        );
    }
}
