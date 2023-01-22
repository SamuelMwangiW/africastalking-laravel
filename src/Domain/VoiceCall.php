<?php

declare(strict_types=1);

namespace SamuelMwangiW\Africastalking\Domain;

use Illuminate\Support\Collection;
use SamuelMwangiW\Africastalking\Saloon\Requests\Voice\CallRequest;
use SamuelMwangiW\Africastalking\ValueObjects\PhoneNumber;
use SamuelMwangiW\Africastalking\ValueObjects\VoiceCallDTO;

class VoiceCall
{
    /** @var Collection<int,PhoneNumber> */
    protected Collection $recipients;
    private PhoneNumber $from;
    protected ?string $clientRequestId = null;

    public function to(PhoneNumber|string|array|null $recipients): static
    {
        if (null === $recipients) {
            return $this;
        }

        if (
            is_string($recipients) ||
            $recipients instanceof PhoneNumber
        ) {
            $recipients = [$recipients];
        }

        $this->recipients = collect($recipients)->map(function ($phone) {
            if ($phone instanceof PhoneNumber) {
                return $phone;
            }

            return PhoneNumber::make($phone);
        });

        return $this;
    }

    public function as(string|PhoneNumber $number): static
    {
        if (is_string($number)) {
            $number = PhoneNumber::make($number);
        }

        $this->from = $number;

        return $this;
    }

    public function requestId(string $id): static
    {
        $this->clientRequestId = $id;

        return $this;
    }

    public function done(): array
    {
        return $this->send();
    }

    public function send(): array
    {
        return CallRequest::make($this->data())
            ->send()
            ->throw()
            ->json();
    }

    public function data(): array
    {
        return [
            "from" => $this->from()->number,
            "clientRequestId" => $this->clientRequestId,
            "to" => $this->recipients
                ->filter(fn (PhoneNumber $number) => $number->isValid())
                ->map(fn (PhoneNumber $number) => $number->number)
                ->implode(','),
        ];
    }

    public function from(): PhoneNumber
    {
        return $this->from ?? PhoneNumber::make(config('africastalking.voice.from'));
    }

    /**
     * @return Collection<int,VoiceCallDTO>|null
     */
    public function calls(): ?Collection
    {
        return null;
    }
}
