<?php

declare(strict_types=1);

namespace SamuelMwangiW\Africastalking\ValueObjects;

use SamuelMwangiW\Africastalking\Contracts\DTOContract;

class RecipientsApiResponse implements DTOContract
{
    public function __construct(
        public int         $statusCode,
        public PhoneNumber $number,
        public string      $cost,
        public string      $status,
        public string      $messageId,
    ) {
    }

    public static function make(array $attributes): RecipientsApiResponse
    {
        return new RecipientsApiResponse(
            statusCode: intval(data_get($attributes, 'statusCode')),
            number: PhoneNumber::make(data_get($attributes, 'number')),
            cost: data_get($attributes, 'cost'),
            status: data_get($attributes, 'status'),
            messageId: data_get($attributes, 'messageId'),
        );
    }

    public function __toString(): string
    {
        return strval(json_encode($this));
    }

    public function __toArray(): array
    {
        return [
            'statusCode' => $this->statusCode,
            'number' => $this->number,
            'cost' => $this->cost,
            'status' => $this->status,
            'messageId' => $this->messageId,
        ];
    }
}
