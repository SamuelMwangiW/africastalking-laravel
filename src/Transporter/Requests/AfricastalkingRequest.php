<?php

namespace SamuelMwangiW\Africastalking\Transporter\Requests;

use Composer\InstalledVersions;
use function config;
use Illuminate\Http\Client\RequestException;
use JustSteveKing\Transporter\Request;
use SamuelMwangiW\Africastalking\Concerns\HasIdempotency;
use SamuelMwangiW\Africastalking\Transporter\Requests\Concerns\ChecksEnvironment;

/**
 * @method static acceptJson()
 * @method static asJson()
 * @method static asForm()
 * @method static retry(int $times, int $sleep = 0, ?callable $when = null, bool $throw = true)
 * @method static withData(array $data)
 * @method static withoutVerifying()
 * @method static withHeaders(array $headers)
 * @method static withUserAgent(string $userAgent)
 */

class AfricastalkingRequest extends Request
{
    use ChecksEnvironment;
    use HasIdempotency;

    protected string $method = 'POST';

    protected string $sandboxBaseUrl = 'https://api.sandbox.africastalking.com/version1/';

    protected string $liveBaseUrl = 'https://api.africastalking.com/version1/';

    /**
     * @return array
     * @throws RequestException
     */
    public function fetch(): array
    {
        return $this
            ->decorate()
            ->send()
            ->throw()
            ->json();
    }

    public function decorate(): static
    {
        return $this->setBaseUri()
            ->addUsername()
            ->addHeaders();
    }

    private function setBaseUri(): static
    {
        $this->baseUrl = $this->isSandbox() ? $this->sandboxBaseUrl : $this->liveBaseUrl;

        return $this;
    }

    private function addHeaders(): static
    {
        $version = InstalledVersions::getPrettyVersion('samuelmwangiw/africastalking-laravel');

        $this->acceptJson()
            ->withUserAgent(userAgent: "samuelmwangiw/africastalking-laravel {$version}")
            ->withHeaders([
                'apiKey' => config(key: 'africastalking.api-key'),
                'Idempotency-Key' => $this->idempotencyKey(),
            ]);

        return $this;
    }

    private function addUsername(): static
    {
        match (mb_strtoupper($this->method)) {
            'GET' => $this->withQuery(['username' => config('africastalking.username')]),
            'POST' => $this->withData(['username' => config('africastalking.username')]),
            default => throw new \OutOfBoundsException('Only GET and POST methods are supported')
        };

        return $this;
    }
}
