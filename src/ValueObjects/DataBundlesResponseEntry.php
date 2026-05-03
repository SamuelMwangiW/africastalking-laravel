<?php

declare(strict_types=1);

namespace SamuelMwangiW\Africastalking\ValueObjects;

use SamuelMwangiW\Africastalking\Contracts\DTOContract;
use SamuelMwangiW\Africastalking\Enum\Status;

class DataBundlesResponseEntry implements DTOContract
{
    public function __construct(
        public readonly PhoneNumber $number,
        public readonly string $provider,
        public readonly Status $status,
        public readonly string $transactionId,
        public readonly Money $value,
        public readonly ?string $errorMessage = null,
    ) {}

    public function __toString(): string
    {
        return (string) json_encode($this);
    }

    public function __toArray(): array
    {
        return [
            'phoneNumber' => $this->number->number,
            'provider' => $this->provider,
            'status' => $this->status->value,
            'transactionId' => $this->transactionId,
            'value' => "{$this->value->currency->value} {$this->value->amount}",
            'error' => $this->errorMessage,
        ];
    }
}
