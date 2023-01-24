<?php

declare(strict_types=1);

namespace SamuelMwangiW\Africastalking\Testing\Fakes;

use Illuminate\Support\Collection;
use SamuelMwangiW\Africastalking\Domain\VoiceCall;
use SamuelMwangiW\Africastalking\ValueObjects\VoiceCallDTO;
use SamuelMwangiW\Africastalking\ValueObjects\VoiceCallResponse;

class VoiceCallFake extends VoiceCall
{
    /**
     * @var Collection<int,VoiceCallDTO>|null
     */
    private ?Collection $calls = null;

    public function send(): VoiceCallResponse
    {
        if (null === $this->calls) {
            $this->calls = collect([]);
        }

        $this->calls->push($this->details());

        return new VoiceCallResponse('None', collect([]));
    }

    /**
     * @return Collection<int,VoiceCallDTO>|null
     */
    public function calls(): ?Collection
    {
        return $this->calls;
    }

    private function details(): VoiceCallDTO
    {
        return new VoiceCallDTO(
            from: $this->from(),
            to: $this->recipients,
            clientRequestId: $this->clientRequestId
        );
    }
}
