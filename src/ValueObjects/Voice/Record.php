<?php

namespace SamuelMwangiW\Africastalking\ValueObjects\Voice;

class Record implements Action
{
    private Say $say;
    private ?string $finishOnKey;
    private ?int $timeout;
    private ?int $maxLength;
    private bool $playBeep;
    private ?string $callbackUrl;
    private bool $trimSilence;

    public static function make(
        string      $say = '',
        string|null $finishOnKey = null,
        int|null    $timeout = null,
        int|null    $maxLength = null,
        bool        $playBeep = false,
        bool        $trimSilence = false,
        string|null $callbackUrl = null,
    ): Record {
        return (new Record())
            ->say($say)
            ->finishOnKey($finishOnKey)
            ->timeout($timeout)
            ->maxLength($maxLength)
            ->playBeep($playBeep)
            ->trimSilence($trimSilence)
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

    public function maxLength(?int $length): static
    {
        $this->maxLength = $length;

        return $this;
    }

    public function playBeep(bool $playBeep = true): static
    {
        $this->playBeep = $playBeep;

        return $this;
    }

    public function trimSilence(bool $trimSilence = true): static
    {
        $this->trimSilence = $trimSilence;

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

        if ($this->maxLength) {
            $options .= " maxLength=\"{$this->maxLength}\"";
        }

        if ($this->playBeep) {
            $options .= " playBeep=\"true\"";
        }

        if ($this->trimSilence) {
            $options .= " trimSilence=\"true\"";
        }

        return strlen($this->say->getMessage())
            ? "<Record{$options}>{$this->say->build()}</Record>"
            : '<Record />';
    }
}
