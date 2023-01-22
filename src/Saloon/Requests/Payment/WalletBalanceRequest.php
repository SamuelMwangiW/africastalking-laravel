<?php

declare(strict_types=1);

namespace SamuelMwangiW\Africastalking\Saloon\Requests\Payment;

use Saloon\Enums\Method;
use Saloon\Traits\Body\HasJsonBody;
use SamuelMwangiW\Africastalking\Enum\Service;
use SamuelMwangiW\Africastalking\Saloon\Requests\BaseRequest;

class WalletBalanceRequest extends BaseRequest
{
    use HasJsonBody;

    public Service $service = Service::PAYMENT;
    protected Method $method = Method::GET;

    public function resolveEndpoint(): string
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
