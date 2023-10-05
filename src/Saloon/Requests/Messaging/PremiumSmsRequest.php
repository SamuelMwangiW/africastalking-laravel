<?php

declare(strict_types=1);

namespace SamuelMwangiW\Africastalking\Saloon\Requests\Messaging;

use Saloon\Contracts\Body\HasBody;
use Saloon\Contracts\Response;
use Saloon\Traits\Body\HasFormBody;
use SamuelMwangiW\Africastalking\Enum\Service;
use SamuelMwangiW\Africastalking\Saloon\Requests\BaseRequest;
use SamuelMwangiW\Africastalking\ValueObjects\SentMessageResponse;

class PremiumSmsRequest extends BaseRequest implements HasBody
{
    use HasFormBody;

    public Service $service = Service::CONTENT;

    public function __construct(private readonly array $data)
    {
    }

    public function resolveEndpoint(): string
    {
        return 'messaging';
    }

    public function createDtoFromResponse(Response $response): SentMessageResponse
    {
        return SentMessageResponse::fromSaloon($response);
    }

    public function defaultBody(): array
    {
        return array_merge(
            $this->data,
            ['username' => $this->username()]
        );
    }
}
