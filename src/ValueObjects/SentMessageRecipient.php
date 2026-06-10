<?php

declare(strict_types=1);

namespace SamuelMwangiW\Africastalking\ValueObjects;

use SamuelMwangiW\Africastalking\Contracts\DTOContract;
use SamuelMwangiW\Africastalking\Enum\Status;

class SentMessageRecipient implements DTOContract
{
    public function __construct(
        public readonly string      $id,
        public readonly int         $statusCode,
        public readonly PhoneNumber $number,
        public readonly string      $cost,
        public readonly Status      $status,
    ) {}

    public function __toString(): string
    {
        return json_encode($this) ?: '';
    }

    public function __toArray(): array
    {
        return [
            'statusCode' => $this->statusCode,
            'number' => $this->number->number,
            'cost' => $this->cost,
            'status' => $this->status->value,
            'messageId' => $this->id,
        ];
    }

    public static function make(array $attributes): SentMessageRecipient
    {
        return new SentMessageRecipient(
            id: data_get($attributes, 'messageId'),
            statusCode: intval(data_get($attributes, 'statusCode')),
            number: PhoneNumber::make(data_get($attributes, 'number')),
            cost: data_get($attributes, 'cost'),
            status: Status::from(data_get($attributes, 'status')),
        );
    }

    public function statusMessage(): string
    {
        return match ($this->statusCode) {
            100 => 'Processed',
            101 => 'Sent',
            102 => 'Queued',
            401 => 'RiskHold',
            402 => 'InvalidSenderId',
            403 => 'InvalidPhoneNumber',
            404 => 'UnsupportedNumberType',
            405 => 'InsufficientBalance',
            406 => 'UserInBlacklist',
            407 => 'CouldNotRoute',
            409 => 'DoNotDisturbRejection',
            500 => 'InternalServerError',
            501 => 'GatewayError',
            502 => 'RejectedByGateway',
            default => 'UnKnown',
        };
    }
}
