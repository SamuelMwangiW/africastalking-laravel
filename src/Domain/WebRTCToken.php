<?php

declare(strict_types=1);

namespace SamuelMwangiW\Africastalking\Domain;

use GuzzleHttp\Exception\GuzzleException;
use Illuminate\Support\Str;
use Saloon\Exceptions\SaloonException;
use SamuelMwangiW\Africastalking\Saloon\Requests\Voice\CapabilityTokenRequest;
use SamuelMwangiW\Africastalking\ValueObjects\CapabilityToken;
use SamuelMwangiW\Africastalking\ValueObjects\PhoneNumber;
use ReflectionException;
use InvalidArgumentException;

class WebRTCToken
{
    public ?string $username = null;
    public ?string $clientName;
    private int $maxlifeTimeSec = 86400;
    public int $lifeTimeSec = 86400;
    public ?PhoneNumber $phone;

    public function for(?string $name = null): static
    {
        $this->clientName = $name;

        return $this;
    }

    public function from(string|PhoneNumber|null $phoneNo = null): static
    {
        if (is_string($phoneNo)) {
            $phoneNo = PhoneNumber::make($phoneNo);
        }

        $this->phone = $phoneNo;

        return $this;
    }

    public function validFor(int $seconds): static
    {
        if ($seconds <= 0) {
            throw new InvalidArgumentException("Negative duration values not allowed");
        }

        if ($seconds > $this->maxlifeTimeSec) {
            throw new InvalidArgumentException("The maximum allowed token duration is 24 Hours");
        }

        $this->lifeTimeSec = $seconds;

        return $this;
    }

    /**
     * @return CapabilityToken
     * @throws ReflectionException
     * @throws \Saloon\Exceptions\InvalidResponseClassException
     * @throws \Saloon\Exceptions\PendingRequestException
     */
    public function send(): CapabilityToken
    {
        return CapabilityTokenRequest::make($this->data())
            ->send()
            ->throw()
            ->dto();
    }

    /**
     * @return CapabilityToken
     * @throws GuzzleException
     * @throws SaloonException
     * @throws ReflectionException
     */
    public function token(): CapabilityToken
    {
        return $this->send();
    }

    public function clientName(): string
    {
        return $this->clientName ?? Str::random();
    }

    public function phone(): string
    {
        return $this->phone?->number ?? config('africastalking.voice.from');
    }

    public function incoming(): string
    {
        return 'true';
    }

    public function outgoing(): string
    {
        return 'true';
    }

    public function expire(): string
    {
        return "{$this->lifeTimeSec}s";
    }

    public function data(): array
    {
        return [
            'phoneNumber' => $this->phone(),
            'clientName' => $this->clientName(),
            'incoming' => $this->incoming(),
            'outgoing' => $this->outgoing(),
            'expire' => $this->expire(),
        ];
    }
}
