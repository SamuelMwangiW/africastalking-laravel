<?php

namespace SamuelMwangiW\Africastalking\Domain;

use Illuminate\Support\Collection;
use SamuelMwangiW\Africastalking\Enum\Currency;
use SamuelMwangiW\Africastalking\Exceptions\AfricastalkingException;
use SamuelMwangiW\Africastalking\Saloon\Requests\Airtime\SendRequest;
use SamuelMwangiW\Africastalking\ValueObjects\AirtimeTransaction;
use SamuelMwangiW\Africastalking\ValueObjects\PhoneNumber;

class Airtime
{
    /**
     * @var Collection<int,AirtimeTransaction> ;
     */
    public Collection $recipients;

    public function __construct()
    {
        /** @phpstan-ignore-next-line */
        $this->recipients = collect();
    }

    /**
     * @param AirtimeTransaction|string $phoneNumber
     * @param string $currencyCode
     * @param int $amount
     * @return $this|Airtime
     * @throws AfricastalkingException
     */
    public function to(
        AirtimeTransaction|string $phoneNumber,
        string $currencyCode = 'KES',
        int $amount = 0,
    ): Airtime {
        return $this->add($phoneNumber, $currencyCode, $amount);
    }

    /**
     * @param AirtimeTransaction|string $phoneNumber
     * @param string $currencyCode
     * @param int $amount
     * @return $this
     * @throws AfricastalkingException
     */
    public function add(
        AirtimeTransaction|string $phoneNumber,
        string $currencyCode = 'KES',
        int $amount = 0,
    ): Airtime {
        if (is_string($phoneNumber) && ! $this->currencyIsValid($currencyCode)) {
            throw AfricastalkingException::invalidCurrencyCode($currencyCode);
        }
        if (is_string($phoneNumber) && ! $this->minimumAmount($amount)) {
            throw AfricastalkingException::invalidCurrencyCode($currencyCode);
        }

        if (! $phoneNumber instanceof AirtimeTransaction) {
            $phoneNumber = new AirtimeTransaction(
                phoneNumber: PhoneNumber::make($phoneNumber),
                currencyCode: Currency::from($currencyCode),
                amount: $amount,
            );
        }

        $this->recipients->push($phoneNumber);

        return $this;
    }

    private function currencyIsValid(string $currencyCode): bool
    {
        return Currency::tryFrom($currencyCode) !== null;
    }

    private function minimumAmount(int $amount): bool
    {
        return $amount >= 5;
    }

    /**
     * @throws \Illuminate\Http\Client\RequestException
     */
    public function send(): array
    {
        $response = (new SendRequest($this->recipients()))->send();

        if ($response->failed()) {
            /** @phpstan-ignore-next-line */
            throw $response->toException();
        }

        return $response->json();
    }

    private function recipients(): string
    {
        return (string)json_encode(
            $this->recipients->map(fn (AirtimeTransaction $recipient) => $recipient->__toArray())->toArray()
        );
    }
}
