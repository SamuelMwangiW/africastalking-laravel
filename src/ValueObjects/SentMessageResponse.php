<?php

declare(strict_types=1);

namespace SamuelMwangiW\Africastalking\ValueObjects;

use Illuminate\Support\Collection;
use Saloon\Contracts\Response;
use SamuelMwangiW\Africastalking\Contracts\DTOContract;
use SamuelMwangiW\Africastalking\Enum\Status;

class SentMessageResponse implements DTOContract
{
    public function __construct(
        public readonly string $message,
        public readonly Collection $recipients
    ) {
    }

    public static function fromSaloon(Response $response): SentMessageResponse
    {
        $data = $response->json('SMSMessageData');

        return new SentMessageResponse(
            message: data_get($data, 'Message'),
            recipients: collect(data_get($data, 'Recipients'))
                ->map(
                    fn (array $recipient) => new SentMessageRecipient(
                        id: data_get($recipient, 'messageId'),
                        statusCode: data_get($recipient, 'statusCode'),
                        number: PhoneNumber::make(data_get($recipient, 'number')),
                        cost: data_get($recipient, 'cost'),
                        status: Status::from(data_get($recipient, 'status')),
                    )
                ),
        );
    }

    public function __toString(): string
    {
        return $this->message;
    }

    public function __toArray(): array
    {
        return [
            'message' => $this->message,
            'recipients' => $this->recipients->toArray(),
        ];
    }
}
