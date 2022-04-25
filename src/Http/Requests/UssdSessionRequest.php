<?php

namespace SamuelMwangiW\Africastalking\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rules\Enum;
use SamuelMwangiW\Africastalking\Enum\Network;
use SamuelMwangiW\Africastalking\Http\Requests\Concerns\HasNetworkCode;
use SamuelMwangiW\Africastalking\Http\Requests\Concerns\HasPhoneNumber;
use SamuelMwangiW\Africastalking\Http\Requests\Concerns\HasUniqueId;

class UssdSessionRequest extends FormRequest
{
    use HasNetworkCode;
    use HasPhoneNumber;
    use HasUniqueId;

    public function rules(): array
    {
        return [
            'sessionId' => ['string', 'required', 'min:32'],
            'phoneNumber' => ['string', 'required', 'min:10', 'max:25'],
            'networkCode' => ['string', 'required', new Enum(Network::class)],
            'serviceCode' => ['string', 'required', 'min:3'],
            'text' => ['string', 'nullable'],
        ];
    }

    public function userInput(): ?string
    {
        return $this->get('text');
    }

    protected function idKey(): string
    {
        return 'sessionId';
    }
}
