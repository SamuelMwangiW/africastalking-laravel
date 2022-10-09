<?php

namespace SamuelMwangiW\Africastalking\Testing\Fakes;

use Illuminate\Support\Collection;
use SamuelMwangiW\Africastalking\ValueObjects\Message;
use SamuelMwangiW\Africastalking\ValueObjects\PhoneNumber;

class MessageFake extends Message
{
    /**
     * @var Collection<int,mixed>|null
     */
    private ?Collection $messages = null;

    /**
     * @return Collection<int,mixed>
     */
    public function send(): Collection
    {
        if (is_null($this->messages)) {
            $this->messages = collect(
                [
                    $this->details(),
                ]
            );

            return collect([[]]);
        }

        $this->messages->push($this->details());

        return collect([[]]);
    }

    /**
     * @return Collection<int,Collection<int,mixed>>|null
     */
    public function messages(): ?Collection
    {
        return $this->messages;
    }

    /**
     * @return Collection<string,Collection<int, string>|int|string|null>
     */
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
                ?->filter(fn (PhoneNumber $number) => $number->isValid())
                ->map(fn (PhoneNumber $number) => $number->number),
        ]);
    }
}
