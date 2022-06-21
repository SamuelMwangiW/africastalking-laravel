<?php

namespace SamuelMwangiW\Africastalking\Saloon\Requests\Payment;

use Sammyjo20\Saloon\Traits\Plugins\HasJsonBody;
use SamuelMwangiW\Africastalking\Enum\Service;
use SamuelMwangiW\Africastalking\Saloon\Requests\BaseRequest;

class StashTopupRequest extends BaseRequest
{
    use HasJsonBody;

    public Service $service = Service::PAYMENT;

    public function __construct(private readonly array $data)
    {
    }

    public function defineEndpoint(): string
    {
        return 'topup/stash';
    }

    public function defaultData(): array
    {
        return array_merge(
            $this->data,
            ['username' => $this->username()]
        );
    }
}
