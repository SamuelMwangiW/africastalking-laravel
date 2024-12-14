<?php

declare(strict_types=1);

namespace SamuelMwangiW\Africastalking\ValueObjects\Voice;

class Play implements Action, CallActionItem
{
    public function __construct(
        private ?string $url = null,
    ){
    }

    public static function make(string $url = ''): Play
    {
        return new Play($url);
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

    public function buildJson(): array
    {
        return [
            "actionType"=> "Play",
            "url" => $this->url,
        ];
    }
}
