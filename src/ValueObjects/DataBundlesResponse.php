<?php

declare(strict_types=1);

namespace SamuelMwangiW\Africastalking\ValueObjects;

use Illuminate\Support\Collection;
use Saloon\Contracts\Response;
use SamuelMwangiW\Africastalking\Enum\Status;

class DataBundlesResponse implements \SamuelMwangiW\Africastalking\Contracts\DTOContract
{
    public function __construct(
        /** @var Collection<int,DataBundlesResponseEntry> $entries */
        public readonly Collection $entries
    ) {
    }

    public static function fromResponse(Response $response): DataBundlesResponse
    {
        $entries = $response
            ->collect('entries')
            ->map(function (array $entry) {
                return new DataBundlesResponseEntry(
                    number: PhoneNumber::make(data_get($entry, 'phoneNumber')),
                    provider: data_get($entry, 'provider'),
                    status: Status::from(data_get($entry, 'status')),
                    transactionId: data_get($entry, 'transactionId'),
                    value: Money::make(data_get($entry, 'value'))
                );
            });

        return new DataBundlesResponse(entries: $entries);
    }

    public function __toString(): string
    {
        return (string) json_encode($this);
    }

    public function __toArray(): array
    {
        return [];
    }
}
