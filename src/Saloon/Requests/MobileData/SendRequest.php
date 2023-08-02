<?php

declare(strict_types=1);

namespace SamuelMwangiW\Africastalking\Saloon\Requests\MobileData;

use Saloon\Contracts\Body\HasBody;
use Saloon\Contracts\Response;
use Saloon\Traits\Body\HasJsonBody;
use SamuelMwangiW\Africastalking\Enum\Service;
use SamuelMwangiW\Africastalking\Saloon\Requests\BaseRequest;
use SamuelMwangiW\Africastalking\ValueObjects\DataBundlesResponse;

class SendRequest extends BaseRequest implements HasBody
{
    use HasJsonBody;

    public Service $service = Service::DATA;

    public function __construct(
        private readonly string $productName,
        private readonly array $recipients,
    ) {
    }

    public function resolveEndpoint(): string
    {
        return 'mobile/data/request';
    }

    public function defaultBody(): array
    {
        return [
            'username' => $this->username(),
            'productName' => $this->productName,
            'recipients' => $this->recipients,
        ];
    }

    public function createDtoFromResponse(Response $response): DataBundlesResponse
    {
        return DataBundlesResponse::fromResponse($response);
    }
}
