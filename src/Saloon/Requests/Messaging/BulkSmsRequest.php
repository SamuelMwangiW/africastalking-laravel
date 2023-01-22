<?php

namespace SamuelMwangiW\Africastalking\Saloon\Requests\Messaging;

use Saloon\Contracts\Body\HasBody;
use Saloon\Traits\Body\HasFormBody;
use SamuelMwangiW\Africastalking\Enum\Service;
use SamuelMwangiW\Africastalking\Saloon\Requests\BaseRequest;

class BulkSmsRequest extends BaseRequest implements HasBody
{
    use HasFormBody;

    public Service $service = Service::BULK_SMS;

    public function __construct(private readonly array $data)
    {
    }

    public function resolveEndpoint(): string
    {
        return 'messaging';
    }

    public function defaultBody(): array
    {
        return array_merge(
            $this->data,
            ['username' => $this->username()]
        );
    }
}
