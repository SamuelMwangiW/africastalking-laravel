<?php

declare(strict_types=1);

namespace SamuelMwangiW\Africastalking\Domain;

use SamuelMwangiW\Africastalking\Enum\CallLeg;
use SamuelMwangiW\Africastalking\Saloon\Requests\Voice\CallTransferRequest;
use SamuelMwangiW\Africastalking\ValueObjects\CallTransferResponse;

class CallTransfer
{
    private ?string $sessionId = null;
    private ?string $phoneNumber = null;
    private ?CallLeg $callLeg = null;
    private ?string $holdMusicUrl = null;

    public function session(?string $sessionId): static
    {
        $this->sessionId = $sessionId;

        return $this;
    }

    public function to(string $phoneNumber): static
    {
        $this->phoneNumber = $phoneNumber;

        return $this;
    }

    public function callLeg(string|CallLeg $callLeg): static
    {
        $this->callLeg = is_string($callLeg) ? CallLeg::from($callLeg) : $callLeg;

        return $this;
    }

    public function holdMusic(?string $url): static
    {
        $this->holdMusicUrl = $url;

        return $this;
    }

    public function send(): CallTransferResponse
    {
        return CallTransferRequest::make($this->data())
            ->send()
            ->throw()
            ->dto();
    }

    private function data(): array
    {
        return [
            'sessionId' => $this->sessionId,
            'phoneNumber' => $this->phoneNumber,
            'callLeg' => $this->callLeg?->value,
            'holdMusicUrl' => $this->holdMusicUrl,
        ];
    }
}
