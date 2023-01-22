<?php

namespace SamuelMwangiW\Africastalking\ValueObjects;

use SamuelMwangiW\Africastalking\Contracts\DTOContract;
use SamuelMwangiW\Africastalking\Enum\Status;

class SentMessageRecipient implements DTOContract
{

    public function __construct(
        public readonly string $id,
        public readonly int $statusCode,
        public readonly PhoneNumber $number,
        public readonly string $cost,
        public readonly Status $status,
    ) {
    }

    public function __toString(): string
    {
        return json_encode($this);
    }

    public function __toArray(): array
    {
        return [
            "statusCode" => 101,
            "number" => "+254700072929",
            "cost" => "KES 0.8000",
            "status" => "Success",
            "messageId" => "ATXid_6eeffa0cc57b469e02c9716f6bb678c2",
        ];
    }
}
