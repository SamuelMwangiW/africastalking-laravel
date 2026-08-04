<?php

declare(strict_types=1);

namespace SamuelMwangiW\Africastalking\ValueObjects;

use SamuelMwangiW\Africastalking\Contracts\DTOContract;
use SamuelMwangiW\Africastalking\Enum\Status;

class CallTransferResponse implements DTOContract
{
    public function __construct(
        public readonly Status $status,
        public readonly string $errorMessage,
    ) {}

    public function __toString(): string
    {
        return (string) json_encode($this->__toArray());
    }

    public function __toArray(): array
    {
        return [
            'status' => $this->status,
            'errorMessage' => $this->errorMessage,
        ];
    }

    public static function make(array $attributes): CallTransferResponse
    {
        $data = data_get($attributes, 'callTransferResponse', $attributes);

        return new CallTransferResponse(
            status: Status::from(data_get($data, 'status')),
            errorMessage: data_get($data, 'errorMessage', ''),
        );
    }

    public function isSuccessful(): bool
    {
        return Status::SUCCESS === $this->status;
    }
}
