<?php

declare(strict_types=1);

namespace SamuelMwangiW\Africastalking\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use SamuelMwangiW\Africastalking\Http\Requests\Concerns\HasPhoneNumber;
use SamuelMwangiW\Africastalking\Http\Requests\Concerns\HasUniqueId;

class AirtimeValidationRequest extends FormRequest
{
    use HasPhoneNumber;
    use HasUniqueId;

    public function rules(): array
    {
        return [
            'transactionId' => [
                'string',
                'required',
                'min:32',
            ],
            'phoneNumber' => [
                'string',
                'required',
                'min:10',
            ],
            'sourceIpAddress' => [
                'required',
                'ip',
            ],
            'currencyCode' => [
                'string',
                'required',
                'size:3',
            ],
            'amount' => [
                'string',
                'required',
                'numeric',
            ],
        ];
    }

    public function sourceIp(): string
    {
        return $this->str(key: 'sourceIpAddress')->value();
    }

    public function amount(): float
    {
        return $this->float(key: 'amount');
    }

    public function currencyCode(): string
    {
        return $this->str(key: 'currencyCode')->value();
    }

    protected function idKey(): string
    {
        return 'transactionId';
    }
}
