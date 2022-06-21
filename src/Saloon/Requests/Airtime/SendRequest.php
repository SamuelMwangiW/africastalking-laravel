<?php

namespace SamuelMwangiW\Africastalking\Saloon\Requests\Airtime;

use Sammyjo20\Saloon\Traits\Plugins\HasFormParams;
use SamuelMwangiW\Africastalking\Enum\Service;
use SamuelMwangiW\Africastalking\Saloon\Requests\BaseRequest;

class SendRequest extends BaseRequest
{
    use HasFormParams;

    public Service $service = Service::AIRTIME;

    public function __construct(
        private readonly string $recipients
    ) {
    }

    public function defineEndpoint(): string
    {
        return 'airtime/send';
    }

    public function defaultData(): array
    {
        return [
            'recipients' => $this->recipients,
            'username' => $this->username(),
        ];
    }
}
