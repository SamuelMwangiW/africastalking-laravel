<?php

declare(strict_types=1);

namespace SamuelMwangiW\Africastalking\ValueObjects\Voice;

class GetDigits implements Action
{
    private Say $say;
    private ?string $finishOnKey;
    private ?int $timeout;
    private ?int $numDigits;
    private ?string $callbackUrl;

    public static function make(
        string      $say,
        string|null $finishOnKey = null,
        int|null    $timeout = null,
        int|null    $numDigits = null,
        string|null $callbackUrl = null,
    ): GetDigits {
        return (new GetDigits())
            ->say($say)
            ->finishOnKey($finishOnKey)
            ->timeout($timeout)
            ->numDigits($numDigits)
            ->callbackUrl($callbackUrl);
    }

    public function say(string $message): static
    {
        $this->say = Say::make($message);

        return $this;
    }

    public function finishOnKey(?string $key): static
    {
        $this->finishOnKey = $key;

        return $this;
    }

    public function timeout(?int $timeout): static
    {
        $this->timeout = $timeout;

        return $this;
    }

    public function numDigits(?int $digits): static
    {
        $this->numDigits = $digits;

        return $this;
    }

    public function callbackUrl(?string $url): static
    {
        $this->callbackUrl = $url;

        return $this;
    }

    public function build(): string
    {
        $options = '';

        if ($this->timeout) {
            $options .= " timeout=\"{$this->timeout}\"";
        }

        if ($this->finishOnKey) {
            $options .= " finishOnKey=\"{$this->finishOnKey}\"";
        }

        if ($this->callbackUrl) {
            $options .= " callbackUrl=\"{$this->callbackUrl}\"";
        }

        if ($this->numDigits) {
            $options .= " numDigits=\"{$this->numDigits}\"";
        }

        return '<GetDigits'.$options.'>'.$this->say->build().'</GetDigits>';
    }
}
