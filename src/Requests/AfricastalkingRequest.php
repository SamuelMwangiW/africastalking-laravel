<?php

namespace SamuelMwangiW\Africastalking\Requests;

use JustSteveKing\Transporter\Request;

class AfricastalkingRequest extends Request
{
    protected string $method = 'POST';

    /**
     * @return array
     * @throws \Illuminate\Http\Client\RequestException
     */
    public function fetch(): array
    {
        $this->decorate();
        $response = $this->send();

        if ($response->failed()) {
            /** @phpstan-ignore-next-line  */
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
        $this->baseUrl = config('africastalking.username') === 'sandbox'
            ? 'https://api.sandbox.africastalking.com/version1/'
            : 'https://api.africastalking.com/version1/';
    }

    private function addHeaders(): void
    {
        /** @phpstan-ignore-next-line */
        $this->withHeaders([
            'apiKey' => config('africastalking.api-key'),
            'accept' => 'application/json',
            'Content-Type' => 'application/json',
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
