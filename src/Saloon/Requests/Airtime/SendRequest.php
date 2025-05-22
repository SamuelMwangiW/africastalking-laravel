<?php

declare(strict_types=1);

namespace SamuelMwangiW\Africastalking\Saloon\Requests\Airtime;

use Saloon\Contracts\Body\HasBody;
use Saloon\Http\Response;
use Saloon\Traits\Body\HasJsonBody;
use SamuelMwangiW\Africastalking\Enum\Service;
use SamuelMwangiW\Africastalking\Saloon\Requests\BaseRequest;
use SamuelMwangiW\Africastalking\ValueObjects\AirtimeResponse;

class SendRequest extends BaseRequest implements HasBody
{
    use HasJsonBody;

    public Service $service = Service::AIRTIME;

    public function __construct(
        private readonly array $recipients,
    ) {}

    public function resolveEndpoint(): string
    {
        return 'airtime/send';
    }

    public function defaultBody(): array
    {
        return [
            'recipients' => $this->recipients,
            'username' => $this->username(),
        ];
    }

    public function createDtoFromResponse(Response $response): AirtimeResponse
    {
        return AirtimeResponse::fromSaloon($response);
    }
}
