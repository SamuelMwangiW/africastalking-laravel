<?php

declare(strict_types=1);

namespace SamuelMwangiW\Africastalking\ValueObjects\Responses;

use Illuminate\Support\Collection;
use Saloon\Http\Response;
use SamuelMwangiW\Africastalking\Contracts\DTOContract;
use SamuelMwangiW\Africastalking\Enum\Currency;
use SamuelMwangiW\Africastalking\Enum\Status;
use SamuelMwangiW\Africastalking\ValueObjects\Money;
use SamuelMwangiW\Africastalking\ValueObjects\PhoneNumber;

class InsightsResponse implements DTOContract
{
    /**
     * @param Collection<int, InsightsResponseItem> $items
     * @param Status $status
     * @param Money $cost
     * @param string $id
     */
    public function __construct(
        public readonly Collection $items,
        public readonly Status     $status,
        public readonly Money      $cost,
        public readonly string     $id,
    ) {}

    public static function fromSaloon(Response $response): InsightsResponse
    {
        $items = $response
            ->collect('responses')
            ->map(
                fn(array $item) => new InsightsResponseItem(
                    id: data_get($item, 'requestId', 'UnsupportedPhoneNumber'),
                    phoneNumber: new PhoneNumber(
                        number: data_get($item, 'phoneNumber.number'),
                        carrier: data_get($item, 'phoneNumber.carrierName'),
                        countryCode: data_get($item, 'phoneNumber.countryCode'),
                        networkCode: data_get($item, 'phoneNumber.networkCode'),
                        numberType: data_get($item, 'phoneNumber.numberType'),
                    ),
                    status: Status::from(data_get($item, 'status')),
                    cost: new Money(
                        amount: data_get($item, 'cost.amount', 0),
                        currency: Currency::from(
                            data_get($item, 'cost.currencyCode', 'USD'),
                        ),
                    ),
                ),
            );

        return new InsightsResponse(
            items: $items,
            status: Status::from(
                $response->json('status'),
            ),
            cost: new Money(
                amount: $response->json('totalCost.amount'),
                currency: Currency::from(
                    $response->json('totalCost.currencyCode'),
                ),
            ),
            id: $response->json('transactionId'),
        );
    }

    public function __toString(): string
    {
        return json_encode($this->__toArray()).PHP_EOL;
    }

    public function __toArray(): array
    {
        return [
            'transactionId' => $this->id,
            'responses' => $this->items,
            'status' => $this->status->value,
            'items' => $this->items->toArray(),
            'cost' => "{$this->cost->currency->value} {$this->cost->amount}",
        ];
    }
}
