<?php

namespace SamuelMwangiW\Africastalking\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rules\Enum;
use SamuelMwangiW\Africastalking\Enum\PaymentProvider;
use SamuelMwangiW\Africastalking\Http\Requests\Concerns\HasPhoneNumber;

class MobileC2BValidationRequest extends FormRequest
{
    use HasPhoneNumber;

    public function rules(): array
    {
        return [
            'provider' => ['required', 'string',new Enum(PaymentProvider::class)],
            'clientAccount' => ['nullable', 'string'],
            'productName' => ['required', 'string'],
            'phoneNumber' => ['required', 'string'],
            'value' => ['required', 'string'],
            'providerMetadata' => ['nullable'],
        ];
    }
}
