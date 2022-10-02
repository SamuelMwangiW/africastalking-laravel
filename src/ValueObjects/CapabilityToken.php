<?php

namespace SamuelMwangiW\Africastalking\ValueObjects;

use Sammyjo20\Saloon\Http\SaloonResponse;
use SamuelMwangiW\Africastalking\Contracts\DTOContract;

class CapabilityToken implements DTOContract
{
    public function __construct(
        public readonly string $clientName,
        public readonly bool $incoming,
        public readonly string $lifeTimeSec,
        public readonly bool $outgoing,
        public readonly string $token
    ) {
    }

    public static function fromSaloon(SaloonResponse $response): CapabilityToken
    {
        $data = $response->json();

        return new CapabilityToken(
            clientName: data_get($data, 'clientName'),
            incoming: data_get($data, 'incoming'),
            lifeTimeSec: data_get($data, 'lifeTimeSec'),
            outgoing: data_get($data, 'outgoing'),
            token: data_get($data, 'token'),
        );
    }

    public function __toString(): string
    {
        return $this->token;
    }

    public function __toArray(): array
    {
        return [
            "clientName" => $this->clientName,
            "incoming" => $this->incoming,
            "lifeTimeSec" => $this->lifeTimeSec,
            "outgoing" => $this->outgoing,
            "token" => $this->token,
        ];
    }
}
