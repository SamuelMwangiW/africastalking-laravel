<?php

namespace SamuelMwangiW\Africastalking\ValueObjects;

use SamuelMwangiW\Africastalking\Contracts\DTOContract;

class PhoneNumberDTO implements DTOContract
{
    public function __construct(
        public string $number,
    ){}

    public function __toString(): string
    {
        return $this->number;
    }

    public function __toArray(): array
    {
        return [
            'number' => $this->number,
        ];
    }
}
