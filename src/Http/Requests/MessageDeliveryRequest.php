<?php

namespace SamuelMwangiW\Africastalking\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;
use Illuminate\Validation\Rules\Enum;
use SamuelMwangiW\Africastalking\Enum\FailureReason;
use SamuelMwangiW\Africastalking\Enum\Network;
use SamuelMwangiW\Africastalking\Enum\Status;

class MessageDeliveryRequest extends FormRequest
{
    public function rules(): array
    {
        return [
            'id' => [
                'required',
                'string',
                'min:32',
            ],
            'phoneNumber' => [
                'required',
                'string',
            ],
            'retryCount' => [
                'required',
                'integer',
                'min:0',
            ],
            'status' => [
                'string',
                'required',
                new Enum(Status::class),
            ],
            'failureReason' => [
                'nullable',
                Rule::requiredIf($this->deliveryFailed()),
                new Enum(FailureReason::class),
            ],
            'networkCode' => [
                'string',
                new Enum(Network::class),
            ],
        ];
    }

    public function id(): string
    {
        return $this->get(key: 'id');
    }

    public function phone(): string
    {
        return $this->get(key: 'phoneNumber');
    }

    public function status(): string
    {
        return $this->get(key: 'status');
    }

    public function network(): ?Network
    {
        return Network::tryFrom(
            $this->get(key: 'networkCode')
        );
    }

    public function deliveryFailed(): bool
    {
        return in_array(
            needle: $this->get(key: 'status'),
            haystack:['Rejected', 'Failed']
        );
    }
}
