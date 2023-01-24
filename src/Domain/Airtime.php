<?php

declare(strict_types=1);

namespace SamuelMwangiW\Africastalking\Domain;

use Illuminate\Support\Collection;
use Saloon\Exceptions\InvalidResponseClassException;
use Saloon\Exceptions\PendingRequestException;
use SamuelMwangiW\Africastalking\Concerns\HasIdempotency;
use SamuelMwangiW\Africastalking\Enum\Currency;
use SamuelMwangiW\Africastalking\Exceptions\AfricastalkingException;
use SamuelMwangiW\Africastalking\Saloon\Requests\Airtime\SendRequest;
use SamuelMwangiW\Africastalking\ValueObjects\AirtimeResponse;
use SamuelMwangiW\Africastalking\ValueObjects\AirtimeTransaction;
use SamuelMwangiW\Africastalking\ValueObjects\PhoneNumber;
use ReflectionException;

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

        if ( ! $phoneNumber instanceof AirtimeTransaction) {
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
        return null !== Currency::tryFrom($currencyCode);
    }

    private function minimumAmount(int $amount): bool
    {
        return $amount >= 5;
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
        return (string)json_encode(
            $this->recipients->map(fn (AirtimeTransaction $recipient) => $recipient->toArray())->toArray()
        );
    }

    /** @internal */
    public function transactions(): array
    {
        return [];
    }
}
