<?php

namespace SamuelMwangiW\Africastalking\Testing\Fakes;

use Illuminate\Support\Collection;
use SamuelMwangiW\Africastalking\Domain\VoiceCall;
use SamuelMwangiW\Africastalking\ValueObjects\VoiceCallDTO;

class VoiceCallFake extends VoiceCall
{
    private ?Collection $calls = null;

    public function send(): array
    {
        if (is_null($this->calls)) {
            $this->calls = collect(
                [
                    $this->details()
                ]
            );

            return [];
        }

        $this->calls->push($this->details());

        return [];
    }

    public function calls(): ?Collection
    {
        return $this->calls;
    }

    private function details(): object
    {
        return new VoiceCallDTO(
            from: $this->from(),
            to: $this->recipients,
            clientRequestId: $this->clientRequestId
        );
    }
}
