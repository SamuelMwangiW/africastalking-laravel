<?php

declare(strict_types=1);

namespace SamuelMwangiW\Africastalking\ValueObjects;

use Illuminate\Support\Collection;
use SamuelMwangiW\Africastalking\Contracts\DTOContract;

class VoiceCallDTO implements DTOContract
{
    public function __construct(
        public readonly PhoneNumber $from,
        /**
         * @var Collection<int,PhoneNumber>
         */
        public readonly Collection $to,
        public readonly ?string $clientRequestId,
    ) {}

    public function __toString(): string
    {
        return "Call from {$this->from->number} id {$this->clientRequestId}";
    }

    public function __toArray(): array
    {
        return [
            'from' => $this->from->number,
            'requestId' => $this->clientRequestId,
            'to' => $this->to
                ->filter(fn(PhoneNumber $number) => $number->isValid())
                ->map(fn(PhoneNumber $number) => $number->number),
        ];
    }
}
