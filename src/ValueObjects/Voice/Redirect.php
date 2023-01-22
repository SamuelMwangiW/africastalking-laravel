<?php

declare(strict_types=1);

namespace SamuelMwangiW\Africastalking\ValueObjects\Voice;

class Redirect implements Action
{
    private string $url;

    public static function make(string $url): Redirect
    {
        return (new Redirect())->url($url);
    }

    public function url(string $url): static
    {
        $this->url = $url;

        return $this;
    }

    public function build(): string
    {
        return "<Redirect>{$this->url}</Redirect>";
    }
}
