<?php

declare(strict_types=1);

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
            'networkCode' => ['integer', 'required', new Enum(Network::class)],
            'serviceCode' => ['string', 'required', 'min:3'],
            'text' => ['string', 'nullable'],
        ];
    }

    protected function prepareForValidation(): void
    {
        $this->merge([
            'networkCode' => $this->integer('networkCode'),
        ]);
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
