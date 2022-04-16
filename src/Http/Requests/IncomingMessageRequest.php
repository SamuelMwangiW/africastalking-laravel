<?php

namespace SamuelMwangiW\Africastalking\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rules\Enum;
use SamuelMwangiW\Africastalking\Enum\Network;

class IncomingMessageRequest extends FormRequest
{
    public function rules(): array
    {
        return [
            'date' => [
                'required',
                'date',
            ],
            'from' => [
                'required',
                'string',
                'min:10',
            ],
            'id' => [
                'required',
                'string',
                'min:32',
            ],
            'linkId' => [
                'nullable',
                'string',
                'min:10',
            ],
            'text' => [
                'required',
                'string',
            ],
            'to' => [
                'required',
                'string',
                'max:25',
            ],
            'networkCode' => [
                'required',
                'string',
                new Enum(Network::class),
            ],
        ];
    }

    public function id(): string
    {
        return $this->get(key: 'id');
    }

    public function linkId(): ?string
    {
        return $this->get(key: 'linkId');
    }

    public function network(): ?Network
    {
        return Network::tryFrom(
            $this->get(key: 'networkCode')
        );
    }

    public function phone(): string
    {
        return $this->get(key: 'from');
    }

    public function recipient(): string
    {
        return $this->get(key: 'to');
    }
}
