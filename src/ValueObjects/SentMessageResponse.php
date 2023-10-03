<?php

declare(strict_types=1);

namespace SamuelMwangiW\Africastalking\ValueObjects;

use Illuminate\Support\Collection;
use Saloon\Http\Response;
use SamuelMwangiW\Africastalking\Contracts\DTOContract;

class SentMessageResponse implements DTOContract
{
    /**
     * @param string $message
     * @param Collection<int,SentMessageRecipient> $recipients
     */
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
            /** @phpstan-ignore-next-line  */
            recipients: collect(data_get($data, 'Recipients'))
                ->map(
                    fn (array $recipient) => SentMessageRecipient::make($recipient)
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
