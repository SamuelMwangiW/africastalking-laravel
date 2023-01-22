<?php

declare(strict_types=1);

namespace SamuelMwangiW\Africastalking\Domain;

use SamuelMwangiW\Africastalking\Enum\Currency;
use SamuelMwangiW\Africastalking\Saloon\Requests\Payment\StashTopupRequest;
use SamuelMwangiW\Africastalking\ValueObjects\StashTopupResponse;

class Stash
{
    private int $amount = 0;
    private Currency $currency = Currency::KENYA;
    private array $metadata = [];
    private ?string $product = null;

    public function send(
        null|string|Currency $currency = null,
        int|null $amount = null
    ): StashTopupResponse {
        if (null !== $currency) {
            $this->currency($currency);
        }

        if (null !== $amount) {
            $this->amount($amount);
        }

        $response = StashTopupRequest::make($this->getData())
            ->send()
            ->throw()
            ->json();

        return StashTopupResponse::make(
            attributes: $response
        );
    }

    public function topup(null|string|Currency $currency = null, int|null $amount = null): StashTopupResponse
    {
        return $this->send($currency, $amount);
    }

    public function amount(int $amount): Stash
    {
        $this->amount = $amount;

        return $this;
    }

    public function currency(string|Currency $currency): Stash
    {
        $this->currency = is_string($currency) ? Currency::from($currency) : $currency;

        return $this;
    }

    public function metadata(array $metadata = []): Stash
    {
        $this->metadata = $metadata;

        return $this;
    }

    public function product(string $product): Stash
    {
        $this->product = $product;

        return $this;
    }

    public function getAmount(): int
    {
        return $this->amount;
    }

    public function getCurrency(): Currency
    {
        return $this->currency;
    }

    public function getMetadata(): array
    {
        return $this->metadata;
    }

    public function getProductName(): string
    {
        return $this->product ?? config('africastalking.payment.product-name');
    }

    private function getData(): array
    {
        return [
            "productName" => $this->getProductName(),
            "currencyCode" => $this->getCurrency()->value,
            "amount" => $this->getAmount(),
            "metadata" => (object)$this->getMetadata(),
        ];
    }
}
