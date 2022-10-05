<?php

namespace SamuelMwangiW\Africastalking\Domain;

use GuzzleHttp\Exception\GuzzleException;
use Illuminate\Support\Str;
use Sammyjo20\Saloon\Exceptions\SaloonException;
use Sammyjo20\Saloon\Exceptions\SaloonRequestException;
use SamuelMwangiW\Africastalking\Saloon\Requests\Voice\CapabilityTokenRequest;
use SamuelMwangiW\Africastalking\ValueObjects\CapabilityToken;
use SamuelMwangiW\Africastalking\ValueObjects\PhoneNumber;

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
     * @throws \ReflectionException
     * @throws GuzzleException
     * @throws SaloonException
     * @throws SaloonRequestException
     */
    public function send(): CapabilityToken
    {
        /** @phpstan-ignore-next-line  */
        return CapabilityTokenRequest::make($this->data())
            ->send()
            ->throw()
            ->dto();
    }

    /**
     * @throws \ReflectionException
     * @throws GuzzleException
     * @throws SaloonException
     * @throws SaloonRequestException
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
