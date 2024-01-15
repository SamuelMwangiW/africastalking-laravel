<?php

declare(strict_types=1);

namespace SamuelMwangiW\Africastalking\ValueObjects;

use SamuelMwangiW\Africastalking\Enum\BundlesUnit;
use SamuelMwangiW\Africastalking\Enum\BundlesValidity;

class MobileDataTransaction
{
    public function __construct(
        public readonly PhoneNumber     $phoneNumber,
        public readonly int             $quantity,
        public readonly BundlesValidity $validity,
        public readonly BundlesUnit     $unit = BundlesUnit::MB,
        public readonly bool            $isPromoBundle = false,
        public readonly array           $meta = [],
    ) {}

    public static function make(
        PhoneNumber     $phoneNumber,
        int             $quantity,
        BundlesValidity $validity,
        BundlesUnit     $unit = BundlesUnit::MB,
        bool            $isPromoBundle = false,
        array           $meta = [],
    ): MobileDataTransaction {
        return new MobileDataTransaction(
            phoneNumber: $phoneNumber,
            quantity: $quantity,
            validity: $validity,
            unit: $unit,
            isPromoBundle: $isPromoBundle,
            meta: $meta
        );
    }

    public function toArray(): array
    {
        return [
            'phoneNumber' => $this->phoneNumber->number,
            'quantity' => $this->quantity,
            'unit' => $this->unit->value,
            'validity' => $this->validity->value,
            'isPromoBundle' => $this->isPromoBundle,
            'metadata' => (object) $this->meta,
        ];
    }
}
