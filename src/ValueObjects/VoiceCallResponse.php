<?php

declare(strict_types=1);

namespace SamuelMwangiW\Africastalking\ValueObjects;

use Illuminate\Support\Collection;
use Saloon\Contracts\Response;
use SamuelMwangiW\Africastalking\Contracts\DTOContract;

class VoiceCallResponse implements DTOContract
{
    /**
     * @param string $errorMessage
     * @param Collection<int,array> $recipients
     */
    public function __construct(
        public readonly string $errorMessage,
        public readonly Collection $recipients,
        public readonly ?int $queueSize = 0,
    ) {
    }

    public static function fromSaloon(Response $response): VoiceCallResponse
    {
        return new VoiceCallResponse(
            errorMessage: $response->json('errorMessage'),
            recipients: $response->collect('entries'),
            queueSize: intval($response->header('X-Current-Queue-Size')),
        );
    }

    public function __toString(): string
    {
        return (string)json_encode($this);
    }

    public function __toArray(): array
    {
        return [];
    }
}
