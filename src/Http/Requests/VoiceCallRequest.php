<?php

namespace SamuelMwangiW\Africastalking\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rules\Enum;
use SamuelMwangiW\Africastalking\Enum\CallDirection;
use SamuelMwangiW\Africastalking\Http\Requests\Concerns\HasPhoneNumber;
use SamuelMwangiW\Africastalking\Http\Requests\Concerns\HasUniqueId;

class VoiceCallRequest extends FormRequest
{
    use HasPhoneNumber;
    use HasUniqueId;

    public function rules(): array
    {
        return [
            'isActive' => ['required', 'boolean'],
            'sessionId' => ['required', 'string', 'min:32'],
            'direction' => ['required', 'string', new Enum(CallDirection::class)],
            'callerNumber' => ['required', 'string', 'min:10'],
            'destinationNumber' => ['required', 'string', 'min:10'],
            'dtmfDigits' => ['nullable', 'string'],
            'callSessionState' => ['nullable', 'string'],
            'callerCarrierName' => ['nullable', 'string'],
            'callerCountryCode' => ['nullable', 'string','max:4'],
            'callStartTime' => ['nullable', 'string'],
        ];
    }

    protected function phoneNumberKey(): string
    {
        return 'callerNumber';
    }

    protected function idKey(): string
    {
        return 'sessionId';
    }
}
