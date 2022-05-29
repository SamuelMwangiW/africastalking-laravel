<?php

namespace SamuelMwangiW\Africastalking\Testing\Fakes;

use Illuminate\Support\Collection;
use SamuelMwangiW\Africastalking\ValueObjects\Message;
use SamuelMwangiW\Africastalking\ValueObjects\PhoneNumber;

class MessageFake extends Message
{
    private ?Collection $messages = null;

    public function send(): Collection
    {
        if (is_null($this->messages)) {
            $this->messages = collect(
                [
                    $this->details()
                ]
            );

            return collect([]);
        }

        $this->messages->push($this->details());

        return collect([]);
    }

    public function messages(): ?Collection
    {
        return $this->messages;
    }

    private function details(): Collection
    {
        return collect([
            'enqueue' => $this->enqueue,
            'keyword' => $this->keyword,
            'linkId' => $this->linkId,
            'bulkSMSMode' => $this->bulkSMSMode,
            'retryDurationInHours' => $this->retryDurationInHours,
            'message' => $this->message,
            'from' => $this->from(),
            'to' => $this->to
                ?->filter(fn(PhoneNumber $number) => $number->isValid())
                ->map(fn(PhoneNumber $number) => $number->number),
        ]);
    }
}
