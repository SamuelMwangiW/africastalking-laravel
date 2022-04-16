<?php

namespace SamuelMwangiW\Africastalking\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class AirtimeValidationRequest extends FormRequest
{
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

    public function id(): string
    {
        return $this->get(key: 'transactionId');
    }

    public function sourceIp(): string
    {
        return $this->get(key: 'sourceIpAddress');
    }

    public function amount(): float
    {
        return floatval($this->get(key: 'amount'));
    }

    public function currencyCode(): string
    {
        return $this->get(key: 'currencyCode');
    }

    public function phone(): string
    {
        return $this->get(key: 'phoneNumber');
    }
}
