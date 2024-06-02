<?php

declare(strict_types=1);

namespace SamuelMwangiW\Africastalking\Domain;

use Illuminate\Support\Collection;
use ReflectionException;
use Saloon\Exceptions\InvalidResponseClassException;
use Saloon\Exceptions\PendingRequestException;
use SamuelMwangiW\Africastalking\Concerns\HasIdempotency;
use SamuelMwangiW\Africastalking\Enum\Currency;
use SamuelMwangiW\Africastalking\Exceptions\AfricastalkingException;
use SamuelMwangiW\Africastalking\Saloon\Requests\Airtime\SendRequest;
use SamuelMwangiW\Africastalking\ValueObjects\AirtimeResponse;
use SamuelMwangiW\Africastalking\ValueObjects\AirtimeTransaction;
use SamuelMwangiW\Africastalking\ValueObjects\PhoneNumber;

class Airtime
{
    use HasIdempotency;

    /**
     * @var Collection<int,AirtimeTransaction> ;
     */
    public Collection $recipients;

    public function __construct()
    {
        $this->recipients = collect([]);
    }

    /**
     * @param AirtimeTransaction|string $phoneNumber
     * @param string|Currency $currencyCode
     * @param int $amount
     * @return $this|Airtime
     * @throws AfricastalkingException
     */
    public function to(
        AirtimeTransaction|string $phoneNumber,
        string|Currency           $currencyCode = 'KES',
        int                       $amount = 0,
    ): Airtime {
        return $this->add($phoneNumber, $currencyCode, $amount);
    }

    /**
     * @param AirtimeTransaction|string $phoneNumber
     * @param string|Currency $currencyCode
     * @param int $amount
     * @return $this
     * @throws AfricastalkingException
     */
    public function add(
        AirtimeTransaction|string $phoneNumber,
        string|Currency           $currencyCode = 'KES',
        int                       $amount = 0,
    ): Airtime {
        if ($phoneNumber instanceof AirtimeTransaction) {
            $this->recipients->push($phoneNumber);

            return $this;
        }

        if (is_string($currencyCode)) {
            $currencyCode = Currency::tryFrom($currencyCode) ?? throw AfricastalkingException::invalidCurrencyCode($currencyCode);
        }

        if ($this->lessThanMinimumAmount($currencyCode, $amount)) {
            throw AfricastalkingException::minimumAmount($amount);
        }

        $phoneNumber = new AirtimeTransaction(
            phoneNumber: PhoneNumber::make($phoneNumber),
            currencyCode: $currencyCode,
            amount: $amount,
        );

        $this->recipients->push($phoneNumber);

        return $this;
    }

    private function lessThanMinimumAmount(Currency $currency, int $amount): bool
    {
        return $amount < $currency->minimumAirtimeAmount();
    }

    /**
     * @return AirtimeResponse
     * @throws ReflectionException
     * @throws InvalidResponseClassException
     * @throws PendingRequestException
     */
    public function send(): AirtimeResponse
    {
        $request = SendRequest::make($this->recipients());

        if ($this->idempotencyKey()) {
            $request->headers()->add('Idempotency-Key', $this->idempotencyKey());
        }

        return $request->send()->throw()->dto();
    }

    private function recipients(): string
    {
        return (string) json_encode(
            $this->recipients->map(fn(AirtimeTransaction $recipient) => $recipient->toArray())->toArray(),
        );
    }

    /** @internal */
    public function transactions(): array
    {
        return [];
    }
}
