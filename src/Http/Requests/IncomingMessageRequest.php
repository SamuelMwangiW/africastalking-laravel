<?php

namespace SamuelMwangiW\Africastalking\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rules\Enum;
use SamuelMwangiW\Africastalking\Enum\Network;
use SamuelMwangiW\Africastalking\Http\Requests\Concerns\HasNetworkCode;
use SamuelMwangiW\Africastalking\Http\Requests\Concerns\HasPhoneNumber;
use SamuelMwangiW\Africastalking\Http\Requests\Concerns\HasUniqueId;

class IncomingMessageRequest extends FormRequest
{
    use HasNetworkCode;
    use HasPhoneNumber;
    use HasUniqueId;

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
                'nullable',
                'string',
                new Enum(Network::class),
            ],
        ];
    }

    protected function idKey(): string
    {
        return 'id';
    }

    public function linkId(): ?string
    {
        return $this->get(key: 'linkId');
    }

    public function recipient(): string
    {
        return $this->get(key: 'to');
    }

    protected function phoneNumberKey(): string
    {
        return 'from';
    }
}
