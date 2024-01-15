<?php

declare(strict_types=1);

namespace SamuelMwangiW\Africastalking\Response;

use Illuminate\Contracts\Support\Responsable;
use Illuminate\Http\Request;
use Illuminate\Routing\ResponseFactory;
use Symfony\Component\HttpFoundation\Response;

class UssdResponse implements Responsable
{
    public function __construct(
        private string $response = '',
        private bool   $expectsInput = true
    ) {}

    public function response(string $response): static
    {
        $this->response = $response;

        return $this;
    }

    public function expectsInput(bool $expectsInput = true): static
    {
        $this->expectsInput = $expectsInput;

        return $this;
    }

    public function end(): static
    {
        return $this->expectsInput(expectsInput: false);
    }

    /**
     * @param Request $request
     * @return Response
     */
    public function toResponse($request): Response
    {
        /** @var ResponseFactory $response */
        $response = app(ResponseFactory::class);

        return $response->make(
            content: $this->getResponse(),
            status: Response::HTTP_OK,
            headers: ['Content-Type' => 'text/plain'],
        );
    }

    public function getResponse(): string
    {
        return $this->getPrefix().$this->response;
    }

    public function getPrefix(): string
    {
        if (blank($this->response)) {
            return 'END Thank you!';
        }

        return $this->expectsInput ? 'CON ' : 'END ';
    }
}
