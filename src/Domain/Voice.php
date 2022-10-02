<?php

namespace SamuelMwangiW\Africastalking\Domain;

use Illuminate\Support\Traits\ForwardsCalls;
use SamuelMwangiW\Africastalking\Response\VoiceResponse;

/** @mixin VoiceResponse */
class Voice
{
    use ForwardsCalls;

    public function call(string|array|null $recipients = null): VoiceCall
    {
        return app(VoiceCall::class)->to($recipients);
    }

    public function webrtc(?string $clientName = null): WebRTCToken
    {
        return app(WebRTCToken::class)->for($clientName);
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
