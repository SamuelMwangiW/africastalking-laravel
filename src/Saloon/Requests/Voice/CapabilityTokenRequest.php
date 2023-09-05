<?php

declare(strict_types=1);

namespace SamuelMwangiW\Africastalking\Saloon\Requests\Voice;

use Saloon\Contracts\Body\HasBody;
use Saloon\Contracts\Response;
use Saloon\Traits\Body\HasJsonBody;
use SamuelMwangiW\Africastalking\Enum\Service;
use SamuelMwangiW\Africastalking\Saloon\Requests\BaseRequest;
use SamuelMwangiW\Africastalking\ValueObjects\CapabilityToken;

class CapabilityTokenRequest extends BaseRequest implements HasBody
{
    use HasJsonBody;

    public Service $service = Service::WEBRTC;

    public function __construct(private readonly array $data)
    {
    }

    public function resolveEndpoint(): string
    {
        return 'capability-token/request';
    }

    public function defaultBody(): array
    {
        return array_merge(
            ['username' => config('africastalking.username')],
            $this->data,
        );
    }

    public function createDtoFromResponse(Response $response): CapabilityToken
    {
        return CapabilityToken::fromSaloon($response, data_get($this->data, 'phoneNumber'));
    }
}
