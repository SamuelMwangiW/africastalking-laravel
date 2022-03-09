<?php

namespace SamuelMwangiW\Africastalking\Requests;

use JustSteveKing\Transporter\Request;
use SamuelMwangiW\Africastalking\Traits\ChecksEnvironment;

class AfricastalkingRequest extends Request
{
    use ChecksEnvironment;

    protected string $method = 'POST';

    protected string $sandboxBaseUrl = 'https://api.sandbox.africastalking.com/version1/';

    protected string $liveBaseUrl = 'https://api.africastalking.com/version1/';

    /**
     * @return array
     * @throws \Illuminate\Http\Client\RequestException
     */
    public function fetch(): array
    {
        $this->decorate();
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

    public function addIdempotencyKey(string|null $key): static
    {
        if ($key) {
            /** @phpstan-ignore-next-line  */
            $this->withHeaders(['Idempotency-Key' => $key]);
        }

        return $this;
    }

    private function setBaseUri(): void
    {
        $this->baseUrl = $this->isSandbox() ? $this->sandboxBaseUrl : $this->liveBaseUrl;
    }

    private function addHeaders(): void
    {
        /** @phpstan-ignore-next-line */
        $this->acceptJson()
            ->asForm()
            ->withHeaders([
                'apiKey' => config('africastalking.api-key'),
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
