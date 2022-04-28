<?php

namespace SamuelMwangiW\Africastalking\Domain;

use SamuelMwangiW\Africastalking\Enum\Currency;
use SamuelMwangiW\Africastalking\Transporter\Requests\Payment\StashTopupRequest;
use SamuelMwangiW\Africastalking\ValueObjects\StashTopupResponse;

class Stash
{
    private int $amount = 0;
    private Currency $currency = Currency::KENYA;
    private array $metadata = [];
    private ?string $product = null;

    public function send(
        null|string|Currency $currency = null,
        int|null             $amount = null
    ): StashTopupResponse {
        if (! is_null($currency)) {
            $this->currency($currency);
        }

        if (! is_null($amount)) {
            $this->amount($amount);
        }

        return StashTopupResponse::make(
            attributes: StashTopupRequest::build()
                ->withData($this->getData())
                ->retry(3)
                ->asJson()
                ->fetch()
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
