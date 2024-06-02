<?php

declare(strict_types=1);

namespace SamuelMwangiW\Africastalking\Saloon\Requests\Application;

use Saloon\Enums\Method;
use Saloon\Http\Response;
use Saloon\Traits\Body\HasJsonBody;
use SamuelMwangiW\Africastalking\Enum\Service;
use SamuelMwangiW\Africastalking\Factories\AccountFactory;
use SamuelMwangiW\Africastalking\Saloon\Requests\BaseRequest;
use SamuelMwangiW\Africastalking\ValueObjects\Balance;

class BalanceRequest extends BaseRequest
{
    use HasJsonBody;

    public Service $service = Service::APPLICATION;
    protected Method $method = Method::GET;

    public function resolveEndpoint(): string
    {
        return 'user';
    }

    public function defaultQuery(): array
    {
        return [
            'username' => $this->username(),
        ];
    }

    public function createDtoFromResponse(Response $response): Balance
    {
        return AccountFactory::make(
            data: $response->json(),
        );
    }
}
