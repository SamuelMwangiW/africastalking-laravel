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

class WebRTCToken
{
    public ?string $username = null;
    public ?string $clientName;
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
        return '86400s';
    }

    private function data(): array
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
