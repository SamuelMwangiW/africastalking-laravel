<?php

namespace SamuelMwangiW\Africastalking\ValueObjects\Voice;

class Say implements Action
{
    private string $message;
    private bool $playBeep = false;
    private string|null $voice = null;

    public static function make(
        string      $message,
        bool        $playBeep = false,
        string|null $voice = null
    ): Say {
        return (new Say())
            ->message($message)
            ->playBeep($playBeep)
            ->voice($voice);
    }

    public function message(string $message): static
    {
        $this->message = $message;

        return $this;
    }

    public function playBeep(bool $playBeep = true): static
    {
        $this->playBeep = $playBeep;

        return $this;
    }

    public function voice(string|null $voice): static
    {
        $this->voice = $voice;

        return $this;
    }

    public function build(): string
    {
        $options = '';
        if (! is_null($this->voice)) {
            $options .= " voice=\"$this->voice\"";
        }

        if ($this->playBeep) {
            $options .= ' playBeep="true"';
        }

        return "<Say{$options}>{$this->message}</Say>";
    }

    public function getMessage(): string
    {
        return $this->message;
    }
}
