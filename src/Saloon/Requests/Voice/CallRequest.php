<?php

declare(strict_types=1);

namespace SamuelMwangiW\Africastalking\Saloon\Requests\Voice;

use Saloon\Contracts\Body\HasBody;
use Saloon\Contracts\Response;
use Saloon\Traits\Body\HasFormBody;
use SamuelMwangiW\Africastalking\Enum\Service;
use SamuelMwangiW\Africastalking\Saloon\Requests\BaseRequest;
use SamuelMwangiW\Africastalking\ValueObjects\VoiceCallResponse;

class CallRequest extends BaseRequest implements HasBody
{
    use HasFormBody;

    public Service $service = Service::VOICE;

    public function __construct(private readonly array $data)
    {
    }

    public function resolveEndpoint(): string
    {
        return 'call';
    }

    public function defaultBody(): array
    {
        return array_merge(
            $this->data,
            ['username' => $this->username()]
        );
    }

    public function createDtoFromResponse(Response $response): VoiceCallResponse
    {
        return VoiceCallResponse::fromSaloon($response);
    }
}
