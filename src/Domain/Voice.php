<?php

namespace SamuelMwangiW\Africastalking\Domain;

use Illuminate\Support\Collection;
use Illuminate\Support\Traits\ForwardsCalls;
use SamuelMwangiW\Africastalking\Response\VoiceResponse;

/** @mixin VoiceResponse */
class Voice
{
    use ForwardsCalls;

    public function call(Collection|string|array|null $recipients = null): VoiceCall
    {
        return app(VoiceCall::class)->to($recipients);
    }

    public function __call(string $method, array $arguments): VoiceResponse
    {
        return $this->forwardCallTo(
            object: app(VoiceResponse::class),
            method: $method,
            parameters: $arguments
        );
    }
}
