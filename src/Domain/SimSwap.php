<?php

declare(strict_types=1);

namespace SamuelMwangiW\Africastalking\Domain;

use Illuminate\Support\Collection;
use SamuelMwangiW\Africastalking\Concerns\HasIdempotency;
use SamuelMwangiW\Africastalking\Saloon\Requests\SimSwap\SendRequest;
use SamuelMwangiW\Africastalking\ValueObjects\PhoneNumber;
use SamuelMwangiW\Africastalking\ValueObjects\Responses\InsightsResponse;

class SimSwap
{
    use HasIdempotency;
    /**
     * @var Collection<int, PhoneNumber>
     */
    public Collection $numbers;

    public function __construct()
    {
        $this->numbers = collect([]);
    }

    public function for(string|PhoneNumber $phoneNumber): static
    {
        return $this->add($phoneNumber);
    }

    public function add(string|PhoneNumber $phoneNumber): static
    {
        if (is_string($phoneNumber)) {
            $phoneNumber = new PhoneNumber($phoneNumber);
        }

        $this->numbers->push($phoneNumber);

        return $this;
    }

    public function send(): InsightsResponse
    {
        $request = SendRequest::make($this->recipients());

        if ($this->idempotencyKey()) {
            $request->headers()->add('Idempotency-Key', $this->idempotencyKey());
        }

        return $request->send()->throw()->dto();
    }

    public function recipients(): array
    {
        return $this->numbers->map(
            fn(PhoneNumber $number) => $number->number,
        )->toArray();
    }
}
