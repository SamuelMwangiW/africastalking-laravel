<?php

namespace SamuelMwangiW\Africastalking\ValueObjects;

use SamuelMwangiW\Africastalking\Contracts\DTOContract;

class PhoneNumber implements DTOContract
{
    public string $number;

    public function __construct(string $number,)
    {
        $this->number = str_replace(search: [' ', '-', '.'], replace: '', subject: $number);
    }

    public static function make(string $phone): PhoneNumber
    {
        return new PhoneNumber($phone);
    }

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

    public function isValid(): bool
    {
        return preg_match(pattern: '/^[+]{0,1}[0-9]{10,15}$/',subject: $this->number) !== false;
    }
}
