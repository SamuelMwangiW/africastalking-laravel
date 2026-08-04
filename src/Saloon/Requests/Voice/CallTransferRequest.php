<?php

declare(strict_types=1);

namespace SamuelMwangiW\Africastalking\Saloon\Requests\Voice;

use Saloon\Contracts\Body\HasBody;
use Saloon\Http\Response;
use Saloon\Traits\Body\HasFormBody;
use SamuelMwangiW\Africastalking\Enum\Service;
use SamuelMwangiW\Africastalking\Saloon\Requests\BaseRequest;
use SamuelMwangiW\Africastalking\ValueObjects\CallTransferResponse;

class CallTransferRequest extends BaseRequest implements HasBody
{
    use HasFormBody;

    public Service $service = Service::VOICE;

    public function __construct(private readonly array $data) {}

    public function resolveEndpoint(): string
    {
        return '/callTransfer';
    }

    public function defaultBody(): array
    {
        return array_merge(
            $this->data,
            ['username' => $this->username()],
        );
    }

    public function createDtoFromResponse(Response $response): CallTransferResponse
    {
        return CallTransferResponse::make($response->json());
    }
}
