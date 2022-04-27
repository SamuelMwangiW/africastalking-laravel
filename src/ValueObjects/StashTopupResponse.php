<?php

namespace SamuelMwangiW\Africastalking\ValueObjects;

use SamuelMwangiW\Africastalking\Contracts\DTOContract;
use SamuelMwangiW\Africastalking\Enum\Status;

class StashTopupResponse implements DTOContract
{
    public function __construct(
        public string $id,
        public Status $status,
        public string $description,
    ) {
    }

    public static function make(array $attributes): StashTopupResponse
    {
        return new StashTopupResponse(
            id: data_get($attributes, 'transactionId'),
            status: Status::from(data_get($attributes, 'status')),
            description: data_get($attributes, 'description'),
        );
    }

    public function __toString(): string
    {
        return strval($this->__toArray());
    }

    public function __toArray(): array
    {
        return [
            'id' => $this->id,
            'status' => $this->status,
            'description' => $this->description,
        ];
    }
}
