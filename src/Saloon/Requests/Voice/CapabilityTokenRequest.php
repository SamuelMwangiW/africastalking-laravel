<?php

namespace SamuelMwangiW\Africastalking\Saloon\Requests\Voice;

use Sammyjo20\Saloon\Http\SaloonResponse;
use Sammyjo20\Saloon\Traits\Plugins\CastsToDto;
use Sammyjo20\Saloon\Traits\Plugins\HasJsonBody;
use SamuelMwangiW\Africastalking\Enum\Service;
use SamuelMwangiW\Africastalking\Saloon\Requests\BaseRequest;
use SamuelMwangiW\Africastalking\ValueObjects\CapabilityToken;

class CapabilityTokenRequest extends BaseRequest
{
    use HasJsonBody;
    use CastsToDto;

    public Service $service = Service::WEBRTC;

    public function __construct(private readonly array $data)
    {
    }

    public function defineEndpoint(): string
    {
        return 'capability-token/request';
    }

    public function defaultData(): array
    {
        return array_merge(
            ['username' => config('africastalking.username')],
            $this->data,
        );
    }

    protected function castToDto(SaloonResponse $response): CapabilityToken
    {
        return CapabilityToken::fromSaloon($response);
    }
}
