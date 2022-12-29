<?php

namespace SamuelMwangiW\Africastalking\Saloon;

use Illuminate\Support\Str;
use Sammyjo20\Saloon\Http\SaloonConnector;
use Sammyjo20\Saloon\Traits\Plugins\AcceptsJson;
use SamuelMwangiW\Africastalking\Enum\Service;

class AfricastalkingConnector extends SaloonConnector
{
    use AcceptsJson;

    protected Service $service;

    /**
     * @throws \Exception
     */
    public function defineBaseUrl(): string
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

    public function defaultHeaders(): array
    {
        return [
            'apiKey' => config(key: 'africastalking.api-key'),
            'User-Agent' => 'samuelmwangiw/africastalking-laravel',
        ];
    }

    public function service(Service $service): void
    {
        $this->service = $service;
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
