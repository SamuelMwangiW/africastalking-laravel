<?php

declare(strict_types=1);

namespace SamuelMwangiW\Africastalking\Saloon\Requests\Payment;

use Saloon\Contracts\Body\HasBody;
use Saloon\Traits\Body\HasJsonBody;
use SamuelMwangiW\Africastalking\Enum\Service;
use SamuelMwangiW\Africastalking\Saloon\Requests\BaseRequest;

class StashTopupRequest extends BaseRequest implements HasBody
{
    use HasJsonBody;

    public Service $service = Service::PAYMENT;

    public function __construct(private readonly array $data)
    {
    }

    public function resolveEndpoint(): string
    {
        return 'topup/stash';
    }

    public function defaultBody(): array
    {
        return array_merge(
            $this->data,
            ['username' => $this->username()]
        );
    }
}
