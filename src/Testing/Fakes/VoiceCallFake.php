<?php

declare(strict_types=1);

namespace SamuelMwangiW\Africastalking\Testing\Fakes;

use Illuminate\Support\Collection;
use SamuelMwangiW\Africastalking\Domain\VoiceCall;
use SamuelMwangiW\Africastalking\ValueObjects\VoiceCallDTO;

class VoiceCallFake extends VoiceCall
{
    /**
     * @var Collection<int,VoiceCallDTO>|null
     */
    private ?Collection $calls = null;

    public function send(): array
    {
        if (null === $this->calls) {
            $this->calls = collect(
                [
                    $this->details(),
                ]
            );

            return [];
        }

        $this->calls->push($this->details());

        return [];
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
