<?php

declare(strict_types=1);

namespace SamuelMwangiW\Africastalking\Testing\Fakes;

use SamuelMwangiW\Africastalking\Domain\Airtime as Base;
use SamuelMwangiW\Africastalking\ValueObjects\AirtimeTransaction;

class AirtimeFake extends Base
{
    private array $trans = [];

    public function send(): array
    {
        $this->trans[] = $this->recipients->map(fn (AirtimeTransaction $recipient) => $recipient->__toArray())->toArray();
        $this->recipients = collect([]);

        return [];
    }

    public function transactions(): array
    {
        return $this->trans;
    }
}
