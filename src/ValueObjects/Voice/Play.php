<?php

declare(strict_types=1);

namespace SamuelMwangiW\Africastalking\ValueObjects\Voice;

class Play implements Action
{
    private string $url;

    public static function make(string $url = ''): Play
    {
        return (new Play())->url($url);
    }

    public function url(string $url): static
    {
        $this->url = $url;

        return $this;
    }

    public function build(): string
    {
        return "<Play url=\"{$this->url}\"/>";
    }
}
