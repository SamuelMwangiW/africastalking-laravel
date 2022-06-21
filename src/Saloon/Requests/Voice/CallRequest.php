<?php

namespace SamuelMwangiW\Africastalking\Saloon\Requests\Voice;

use Sammyjo20\Saloon\Traits\Plugins\HasFormParams;
use SamuelMwangiW\Africastalking\Enum\Service;
use SamuelMwangiW\Africastalking\Saloon\Requests\BaseRequest;

class CallRequest extends BaseRequest
{
    use HasFormParams;

    public Service $service = Service::VOICE;

    public function __construct(private readonly array $data)
    {
    }

    public function defineEndpoint(): string
    {
        return 'call';
    }

    public function defaultData(): array
    {
        return array_merge(
            $this->data,
            ['username' => $this->username()]
        );
    }
}
