<?php

namespace SamuelMwangiW\Africastalking\Saloon\Requests\Application;

use Sammyjo20\Saloon\Constants\Saloon;
use SamuelMwangiW\Africastalking\Enum\Service;
use SamuelMwangiW\Africastalking\Saloon\Requests\BaseRequest;

class BalanceRequest extends BaseRequest
{
    public Service $service = Service::APPLICATION;
    protected ?string $method = Saloon::GET;

    public function defineEndpoint(): string
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
