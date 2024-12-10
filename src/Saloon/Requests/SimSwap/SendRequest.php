<?php

declare(strict_types=1);

namespace SamuelMwangiW\Africastalking\Saloon\Requests\SimSwap;

use Saloon\Contracts\Body\HasBody;
use Saloon\Http\Response;
use Saloon\Traits\Body\HasJsonBody;
use SamuelMwangiW\Africastalking\Enum\Service;
use SamuelMwangiW\Africastalking\Saloon\Requests\BaseRequest;
use SamuelMwangiW\Africastalking\ValueObjects\Responses\InsightsResponse;

class SendRequest extends BaseRequest implements HasBody
{
    use HasJsonBody;

    public Service $service = Service::INSIGHTS;

    public function __construct(
        private readonly array $phoneNumbers,
    ) {}

    public function defaultBody(): array
    {
        return [
            'username' => $this->username(),
            'phoneNumbers' => $this->phoneNumbers,
        ];
    }

    /**
     * @inheritDoc
     */
    public function resolveEndpoint(): string
    {
        return '/sim-swap';
    }

    public function createDtoFromResponse(Response $response): InsightsResponse
    {
        return InsightsResponse::fromSaloon($response);
    }
}
