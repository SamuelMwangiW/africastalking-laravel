<?php

namespace SamuelMwangiW\Africastalking\Domain;

use Illuminate\Support\Str;

class WebRTCToken
{
    public ?string $apiKey = null;
    public ?string $username = null;
    public ?string $clientName;
    public ?string $phone;

    public function for(?string $name = null): static
    {
        $this->clientName = $name;

        return $this;
    }

    public function from(?string $phoneNo = null): static
    {
        $this->phone = $phoneNo;

        return $this;
    }

    public function send()
    {

    }

    public function clientName(): string
    {
        return $this->clientName ?? Str::random();
    }

    public function phone(): string
    {
        return $this->phone ?? config('africastalking.voice.from');
    }

    public function incoming(): bool
    {
        return true;
    }

    public function outgoing(): bool
    {
        return true;
    }

    public function expire(): string
    {
        return '86400s';
    }
}
