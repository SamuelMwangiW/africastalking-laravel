<?php

declare(strict_types=1);

namespace SamuelMwangiW\Africastalking\ValueObjects\Voice;

class SynthesisedSpeech implements Action
{
    private string $message = '';

    public function say(string $message): static
    {
        $this->message .= $message;

        return $this;
    }

    public function break(?string $time = null): static
    {
        $this->message .= '<break time="'.$time.'"/>';

        return $this;
    }

    public function pause(?string $time = null): static
    {
        return $this->break($time);
    }

    public function sayAsCurrency(string $value, string $language): static
    {
        $this->message .= '<say-as interpret-as="currency" language="'.$language.'">'.$value.'</say-as>';

        return $this;
    }

    public function sayAsTelephone(string $value): static
    {
        $this->message .= '<say-as interpret-as="telephone" google:style="zero-as-zero">'.$value.'</say-as>';

        return $this;
    }

    public function sayAsDate(string $value, string $format = "yyyymmdd", int $detail = 1): static
    {
        $this->message .= '<say-as interpret-as="date" format="'.$format.'" detail="'.$detail.'">'.$value.'</say-as>';

        return $this;
    }

    public function sayAsTime(string $value, string $format = "hms12"): static
    {
        $this->message .= '<say-as interpret-as="time" format="'.$format.'">'.$value.'}</say-as>';

        return $this;
    }

    public function sayAsVerbatim(string $value): static
    {
        return $this->sayAs('verbatim', $value);
    }

    public function sayAsSpeltOut(string $value): static
    {
        return $this->sayAs('spell-out', $value);
    }

    public function sayAsCharacters(string $value): static
    {
        return $this->sayAs('characters', $value);
    }

    public function sayAsCardinal(string $value): static
    {
        return $this->sayAs('cardinal', $value);
    }

    public function sayAsOrdinal(string $value): static
    {
        return $this->sayAs('ordinal', $value);
    }

    public function sayAsFraction(string $value): static
    {
        return $this->sayAs('fraction', $value);
    }

    public function bleep(string $value): static
    {
        return $this->sayAs('bleep', $value);
    }

    public function expletive(string $value): static
    {
        return $this->sayAs('expletive', $value);
    }

    public function emphasis(string $message, string $level = 'strong'): static
    {
        $this->message .= '<emphasis level="'.$level.'">'.$message.'</emphasis>';

        return $this;
    }

    public function sayAs(string $as, string $value): static
    {
        $this->message .= '<say-as interpret-as="'.$as.'">'.$value.'</say-as>';

        return $this;
    }

    public function build(): string
    {
        return "<speak>{$this->message}</speak>";
    }
}
