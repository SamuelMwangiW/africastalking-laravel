<?php

declare(strict_types=1);

namespace SamuelMwangiW\Africastalking\ValueObjects;

use SamuelMwangiW\Africastalking\Contracts\DTOContract;

class PhoneNumber implements DTOContract
{
    public function __construct(
        public string $number,
        public readonly ?string $carrier = null,
        public readonly ?int $countryCode = null,
        public readonly ?string $networkCode = null,
        public readonly ?string $numberType = null,
    ) {
        $this->number = str_replace(search: [' ', '-', '.'], replace: '', subject: $number);
    }

    public function __toString(): string
    {
        return $this->number;
    }

    public function __toArray(): array
    {
        return [
            'number' => $this->number,
            'carrier' => $this->carrier,
            'countryCode' => $this->countryCode,
            'networkCode' => $this->networkCode,
            'numberType' => $this->numberType,
        ];
    }

    public static function make(string $phone): PhoneNumber
    {
        return new PhoneNumber($phone);
    }

    public function isValid(): bool
    {
        return false !== preg_match(pattern: '/^[+]{0,1}[0-9]{10,15}$/', subject: $this->number);
    }
}
