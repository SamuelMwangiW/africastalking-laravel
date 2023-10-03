<?php

declare(strict_types=1);

namespace SamuelMwangiW\Africastalking\Saloon\Requests\Voice;

use Saloon\Contracts\Body\HasBody;
use Saloon\Http\Response;
use Saloon\Traits\Body\HasFormBody;
use SamuelMwangiW\Africastalking\Enum\Service;
use SamuelMwangiW\Africastalking\Saloon\Requests\BaseRequest;

class QueueStatusRequest extends BaseRequest implements HasBody
{
    use HasFormBody;

    public Service $service = Service::VOICE;

    public function __construct(private readonly array $data)
    {
    }
    public function defaultBody(): array
    {
        return array_merge(
            $this->data,
            ['username' => $this->username()]
        );
    }

    /**
     * @inheritDoc
     */
    public function resolveEndpoint(): string
    {
        return '/queueStatus';
    }

    public function createDtoFromResponse(Response $response): mixed
    {
        return $response->json();
    }
}
