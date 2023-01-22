<?php

namespace SamuelMwangiW\Africastalking\Saloon;

use Illuminate\Support\Str;
use Saloon\Http\Connector;
use Saloon\Traits\Plugins\AcceptsJson;
use SamuelMwangiW\Africastalking\Enum\Service;

class AfricastalkingConnector extends Connector
{
    use AcceptsJson;

    protected Service $service;

    /**
     * @throws \Exception
     */
    public function resolveBaseUrl(): string
    {
        return $this->isSandboxEnvironment()
            ? $this->service->sandboxBaseUrl()
            : $this->service->liveBaseUrl();
    }

    public function defaultConfig(): array
    {
        return [
            'timeout' => 30,
        ];
    }

    public function service(Service $service): static
    {
        $this->service = $service;

        return $this;
    }

    public function username(): string
    {
        return config(key: 'africastalking.username');
    }

    private function isSandboxEnvironment(): bool
    {
        return Str::of($this->username())
            ->lower()
            ->trim()
            ->is('sandbox');
    }
}
