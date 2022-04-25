<?php

namespace SamuelMwangiW\Africastalking\Transporter\Requests;

use Composer\InstalledVersions;
use Illuminate\Http\Client\PendingRequest;
use JustSteveKing\Transporter\Request;
use SamuelMwangiW\Africastalking\Concerns\HasIdempotency;
use SamuelMwangiW\Africastalking\Transporter\Requests\Concerns\ChecksEnvironment;
use function config;

/** @mixin PendingRequest */
class AfricastalkingRequest extends Request
{
    use ChecksEnvironment;
    use HasIdempotency;

    protected string $method = 'POST';

    protected string $sandboxBaseUrl = 'https://api.sandbox.africastalking.com/version1/';

    protected string $liveBaseUrl = 'https://api.africastalking.com/version1/';

    /**
     * @return array
     * @throws \Illuminate\Http\Client\RequestException
     */
    public function fetch(): array
    {
        $this->decorate()->retry(times: 3);
        $response = $this->send();

        if ($response->failed()) {
            /** @phpstan-ignore-next-line */
            throw $response->toException();
        }

        return $response->json();
    }

    public function decorate(): static
    {
        $this->setBaseUri();
        $this->addUsername();
        $this->addHeaders();

        return $this;
    }

    private function setBaseUri(): void
    {
        $this->baseUrl = $this->isSandbox() ? $this->sandboxBaseUrl : $this->liveBaseUrl;
    }

    private function addHeaders(): void
    {
        $version = InstalledVersions::getPrettyVersion('samuelmwangiw/africastalking-laravel');

        $this->acceptJson()
            ->withUserAgent(userAgent: "samuelmwangiw/africastalking-laravel {$version}")
            ->asForm()
            ->withHeaders([
                'apiKey' => config(key: 'africastalking.api-key'),
                'Idempotency-Key' => $this->idempotencyKey,
            ]);
    }

    private function addUsername(): void
    {
        if ($this->method === 'GET') {
            $this->withQuery([
                'username' => config('africastalking.username'),
            ]);

            return;
        }

        $this->withData([
            'username' => config('africastalking.username'),
        ]);
    }
}
