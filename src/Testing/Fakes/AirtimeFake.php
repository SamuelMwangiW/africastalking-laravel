<?php

declare(strict_types=1);

namespace SamuelMwangiW\Africastalking\Testing\Fakes;

use SamuelMwangiW\Africastalking\Domain\Airtime as Base;
use SamuelMwangiW\Africastalking\ValueObjects\AirtimeResponse;
use SamuelMwangiW\Africastalking\ValueObjects\AirtimeTransaction;

class AirtimeFake extends Base
{
    private array $trans = [];

    public function send(): AirtimeResponse
    {
        $this->trans[] = $this->recipients->map(fn(AirtimeTransaction $recipient) => $recipient->__toArray())->toArray(
        );
        $this->recipients = collect([]);

        return new AirtimeResponse(
            errorMessage: 'None',
            amount: 'KES 420',
            discount: 'KES 16.80',
            numSent: 1,
            responses: collect([]),
        );
    }

    public function transactions(): array
    {
        return $this->trans;
    }
}
