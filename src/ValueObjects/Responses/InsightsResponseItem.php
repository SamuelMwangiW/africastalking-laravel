<?php

declare(strict_types=1);

namespace SamuelMwangiW\Africastalking\ValueObjects\Responses;

use SamuelMwangiW\Africastalking\Contracts\DTOContract;
use SamuelMwangiW\Africastalking\Enum\Status;
use SamuelMwangiW\Africastalking\ValueObjects\Money;
use SamuelMwangiW\Africastalking\ValueObjects\PhoneNumber;

class InsightsResponseItem implements DTOContract
{
    public function __construct(
        public readonly string $id,
        public readonly PhoneNumber $phoneNumber,
        public readonly Status $status,
        public readonly Money $cost,
    ) {}

    public function __toString(): string
    {
        return '';
    }

    public function __toArray(): array
    {
        return [];
    }
}
