<?php

namespace SamuelMwangiW\Africastalking\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Http\Request;
use Illuminate\Validation\Rules\Enum;
use SamuelMwangiW\Africastalking\Enum\UpdateType;
use SamuelMwangiW\Africastalking\Http\Requests\Concerns\HasPhoneNumber;

class SubscriptionRequest extends FormRequest
{
    use HasPhoneNumber;

    public function rules(): array
    {
        return [
            'phoneNumber' => ['string', 'required', 'min:10', 'max:18'],
            'shortCode' => ['string', 'required', 'min:3', 'max:18'],
            'keyword' => ['string', 'nullable', 'min:3', 'max:18'],
            'updateType' => ['string', 'required', new Enum(UpdateType::class)],
        ];
    }

    public function type(): UpdateType
    {
        return UpdateType::from(
            $this->get('updateType')
        );
    }
}
