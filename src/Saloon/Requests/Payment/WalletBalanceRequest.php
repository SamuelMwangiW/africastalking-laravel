<?php

namespace SamuelMwangiW\Africastalking\Saloon\Requests\Payment;

use Sammyjo20\Saloon\Constants\Saloon;
use SamuelMwangiW\Africastalking\Enum\Service;
use SamuelMwangiW\Africastalking\Saloon\Requests\BaseRequest;

class WalletBalanceRequest extends BaseRequest
{
    public Service $service = Service::PAYMENT;
    protected ?string $method = Saloon::GET;

    public function defineEndpoint(): string
    {
        return 'query/wallet/balance';
    }

    public function defaultQuery(): array
    {
        return [
            'username' => $this->username(),
        ];
    }
}
