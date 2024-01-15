<?php

declare(strict_types=1);

namespace SamuelMwangiW\Africastalking\ValueObjects;

use Illuminate\Support\Collection;
use Saloon\Http\Response;
use SamuelMwangiW\Africastalking\Contracts\DTOContract;

class AirtimeResponse implements DTOContract
{
    /**
     * @param string $errorMessage
     * @param string $amount
     * @param string $discount
     * @param int $numSent
     * @param Collection<int,AirtimeRecipientResponse> $responses
     */
    public function __construct(
        public readonly string $errorMessage,
        public readonly string $amount,
        public readonly string $discount,
        public readonly int $numSent,
        public readonly Collection $responses,
    ) {}

    public static function fromSaloon(Response $response): AirtimeResponse
    {
        return new AirtimeResponse(
            errorMessage: $response->json('errorMessage'),
            amount: $response->json('totalAmount'),
            discount: $response->json('totalDiscount'),
            numSent: $response->json('numSent'),
            responses: $response->collect('responses')
                ->map(
                    fn(array $response) => AirtimeRecipientResponse::make($response)
                ),
        );
    }

    public function __toString(): string
    {
        return (string) json_encode($this);
    }

    public function hasDuplicate(): bool
    {
        return 'A duplicate request was received within the last 5 minutes' === $this->errorMessage;
    }

    public function __toArray(): array
    {
        return [
            'error' => $this->errorMessage,
            'total' => $this->amount,
            'discount' => $this->discount,
        ];
    }
}
