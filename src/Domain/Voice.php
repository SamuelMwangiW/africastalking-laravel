<?php

declare(strict_types=1);

namespace SamuelMwangiW\Africastalking\Domain;

use Illuminate\Support\Traits\ForwardsCalls;
use SamuelMwangiW\Africastalking\Response\VoiceResponse;
use SamuelMwangiW\Africastalking\ValueObjects\PhoneNumber;

/** @mixin VoiceResponse */
class Voice
{
    use ForwardsCalls;

    public function __call(string $method, array $arguments): VoiceResponse
    {
        return $this->forwardCallTo(
            object: app(VoiceResponse::class),
            method: $method,
            parameters: $arguments,
        );
    }

    public function call(PhoneNumber|string|array|null $recipients = null): VoiceCall
    {
        return app(VoiceCall::class)->to($recipients);
    }

    public function webrtc(?string $clientName = null): WebRTCToken
    {
        return app(WebRTCToken::class)->for($clientName);
    }

    public function queueStatus(?array $phoneNumbers = null): QueueStatus
    {
        return app(QueueStatus::class)->for($phoneNumbers);
    }
}
