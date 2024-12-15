<?php

declare(strict_types=1);

namespace SamuelMwangiW\Africastalking\Domain;

use Illuminate\Support\Collection;
use SamuelMwangiW\Africastalking\Saloon\Requests\Voice\CallRequest;
use SamuelMwangiW\Africastalking\ValueObjects\PhoneNumber;
use SamuelMwangiW\Africastalking\ValueObjects\Voice\CallActionItem;
use SamuelMwangiW\Africastalking\ValueObjects\Voice\Dial;
use SamuelMwangiW\Africastalking\ValueObjects\Voice\Play;
use SamuelMwangiW\Africastalking\ValueObjects\Voice\Say;
use SamuelMwangiW\Africastalking\ValueObjects\VoiceCallDTO;
use SamuelMwangiW\Africastalking\ValueObjects\VoiceCallResponse;

class VoiceCall
{
    /** @var Collection<int,PhoneNumber> */
    protected Collection $recipients;
    private PhoneNumber $from;
    protected ?string $clientRequestId = null;

    protected array $actions = [];

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

    public function dial(array $phoneNumbers, bool $record = false, bool $sequential = true): static
    {
        $this->actions[] = Dial::make(
            phoneNumbers: $phoneNumbers,
            record: $record,
            sequential: $sequential,
        );

        return $this;
    }

    public function say(string $message, ?string $voice = null, bool $playBeep = false): static
    {
        $this->actions[] = Say::make(
            message: $message,
            playBeep: $playBeep,
            voice: $voice,
        );

        return $this;
    }

    public function play(string $url): static
    {
        $this->actions[] = Play::make(url: $url);

        return $this;
    }

    public function done(): VoiceCallResponse
    {
        return $this->send();
    }

    public function send(): VoiceCallResponse
    {
        return CallRequest::make($this->data())
            ->send()
            ->throw()
            ->dto();
    }

    public function data(): array
    {
        $payload = [
            'from' => $this->from()->number,
            'clientRequestId' => $this->clientRequestId,
            'to' => $this->recipients
                ->filter(fn(PhoneNumber $number) => $number->isValid())
                ->map(fn(PhoneNumber $number) => $number->number)
                ->toArray(),
        ];

        foreach ($this->actions as $action) {
            /** @var CallActionItem $action */
            $payload['callActions'][] = $action->buildJson();
        }

        return $payload;
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
