<?php

namespace SamuelMwangiW\Africastalking\Tests\Fixtures;

use Saloon\Contracts\Body\HasBody;
use Saloon\Contracts\Response;
use Saloon\Http\Request;
use Saloon\Enums\Method;
use Saloon\Traits\Body\HasJsonBody;
use SamuelMwangiW\Africastalking\ValueObjects\CapabilityToken;

class TestRequest extends Request implements HasBody
{
    use HasJsonBody;

    protected Method $method = Method::POST;

    public function resolveEndpoint(): string
    {
        return 'capability-token/request';
    }

    public function createDtoFromResponse(Response $response): CapabilityToken
    {
        return CapabilityToken::fromSaloon($response);
    }
}
