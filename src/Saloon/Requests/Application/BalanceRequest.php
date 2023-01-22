<?php

declare(strict_types=1);

namespace SamuelMwangiW\Africastalking\Saloon\Requests\Application;

use Saloon\Enums\Method;
use Saloon\Traits\Body\HasJsonBody;
use SamuelMwangiW\Africastalking\Enum\Service;
use SamuelMwangiW\Africastalking\Saloon\Requests\BaseRequest;

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
}
