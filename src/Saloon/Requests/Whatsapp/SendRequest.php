<?php

declare(strict_types=1);

namespace SamuelMwangiW\Africastalking\Saloon\Requests\Whatsapp;

use Saloon\Contracts\Body\HasBody;
use Saloon\Http\Response;
use Saloon\Traits\Body\HasJsonBody;
use SamuelMwangiW\Africastalking\Enum\Service;
use SamuelMwangiW\Africastalking\Saloon\Requests\BaseRequest;

class SendRequest extends BaseRequest implements HasBody
{
    use HasJsonBody;

    public Service $service = Service::WHATSAPP;

    public function __construct(private readonly array $data) {}

    public function resolveEndpoint(): string
    {
        return '/message/send';
    }

    public function defaultBody(): array
    {
        return array_merge(
            $this->data,
            ['username' => $this->username()],
        );
    }

    public function createDtoFromResponse(Response $response): mixed
    {
        return $response->json();
    }
}
