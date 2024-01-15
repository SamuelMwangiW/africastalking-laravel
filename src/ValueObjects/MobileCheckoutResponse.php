<?php

declare(strict_types=1);

namespace SamuelMwangiW\Africastalking\ValueObjects;

use SamuelMwangiW\Africastalking\Contracts\DTOContract;

class MobileCheckoutResponse implements DTOContract
{
    public function __construct(
        public readonly string $id,
        public readonly string $description,
        public readonly string $providerChannel,
        public readonly string $status,
    ) {}

    public static function make(mixed $details): MobileCheckoutResponse
    {
        return new MobileCheckoutResponse(
            id: data_get($details, 'transactionId'),
            description: data_get($details, 'description'),
            providerChannel: data_get($details, 'providerChannel'),
            status: data_get($details, 'status'),
        );
    }

    public function hasDuplicate(): bool
    {
        return 'DuplicateRequest' === $this->status;
    }

    public function __toString(): string
    {
        return (string) json_encode($this);
    }

    public function __toArray(): array
    {
        return [
            'description' => $this->description,
            'providerChannel' => $this->providerChannel,
            'status' => $this->status,
            'transactionId' => $this->id,
        ];
    }
}
