<?php

namespace SamuelMwangiW\Africastalking\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rules\Enum;
use SamuelMwangiW\Africastalking\Enum\Status;

class AirtimeStatusRequest extends FormRequest
{
    public function rules(): array
    {
        return [
            'requestId' => [
                'string',
                'required',
                'min:32',
            ],
            'phoneNumber' => [
                'string',
                'required',
                'min:10',
            ],
            'description' => [
                'string',
                'required',
            ],
            'status' => [
                'string',
                'required',
                new Enum(Status::class),
            ],
            'value' => [
                'string',
                'required',
                'string',
            ],
            'discount' => [
                'string',
                'required',
                'string',
            ],
        ];
    }

    public function id(): string
    {
        return $this->get(key: 'requestId');
    }

    public function value(): string
    {
        return $this->get(key: 'value');
    }

    public function discount(): string
    {
        return $this->get(key: 'discount');
    }

    public function phone(): string
    {
        return $this->get(key: 'phoneNumber');
    }
}
