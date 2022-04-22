<?php

namespace SamuelMwangiW\Africastalking\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;
use Illuminate\Validation\Rules\Enum;
use SamuelMwangiW\Africastalking\Enum\FailureReason;
use SamuelMwangiW\Africastalking\Enum\Network;
use SamuelMwangiW\Africastalking\Enum\Status;
use SamuelMwangiW\Africastalking\Http\Requests\Concerns\HasNetworkCode;
use SamuelMwangiW\Africastalking\Http\Requests\Concerns\HasPhoneNumber;
use SamuelMwangiW\Africastalking\Http\Requests\Concerns\HasStatus;
use SamuelMwangiW\Africastalking\Http\Requests\Concerns\HasUniqueId;

class MessageDeliveryRequest extends FormRequest
{
    use HasNetworkCode;
    use HasPhoneNumber;
    use HasUniqueId;
    use HasStatus;

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
                'required',
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
                'required',
                'string',
                new Enum(Network::class),
            ],
        ];
    }

    protected function idKey(): string
    {
        return 'id';
    }

    public function deliveryFailed(): bool
    {
        return in_array(
            needle: $this->get(key: 'status'),
            haystack:['Rejected', 'Failed']
        );
    }
}
