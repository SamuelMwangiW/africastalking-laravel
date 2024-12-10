<?php

declare(strict_types=1);

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
    use HasStatus;
    use HasUniqueId;

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
                'integer',
                new Enum(Network::class),
            ],
        ];
    }

    protected function prepareForValidation(): void
    {
        $this->merge([
            'networkCode' => $this->integer('networkCode'),
        ]);
    }

    protected function idKey(): string
    {
        return 'id';
    }

    public function deliveryFailed(): bool
    {
        return in_array(
            needle: $this->get(key: 'status'),
            haystack: ['Rejected', 'Failed'],
        );
    }
}
