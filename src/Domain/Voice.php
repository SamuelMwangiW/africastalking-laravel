<?php

namespace SamuelMwangiW\Africastalking\Domain;

use Illuminate\Support\Traits\ForwardsCalls;
use SamuelMwangiW\Africastalking\Response\VoiceResponse;

/** @mixin VoiceResponse */
class Voice
{
    use ForwardsCalls;

    public function __call(string $method, array $arguments): VoiceResponse
    {
        return $this->forwardCallTo(
            object: app(VoiceResponse::class),
            method: $method,
            parameters: $arguments
        );
    }
}
