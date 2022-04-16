<?php

namespace SamuelMwangiW\Africastalking\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rules\Enum;
use SamuelMwangiW\Africastalking\Enum\CallDirection;
use SamuelMwangiW\Africastalking\Enum\CallHangupCauses;
use SamuelMwangiW\Africastalking\Enum\Currency;
use SamuelMwangiW\Africastalking\Http\Requests\Concerns\HasPhoneNumber;
use SamuelMwangiW\Africastalking\Http\Requests\Concerns\HasUniqueId;

class VoiceEventRequest extends FormRequest
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
            'recordingUrl ' => ['nullable', 'url'],
            'durationInSeconds  ' => ['nullable', 'int','min:0'],
            'currencyCode' => ['nullable', 'string',new Enum(Currency::class)],
            'amount' => ['nullable', 'numeric'],
            'dialDestinationNumber' => ['nullable', 'string'],
            'dialDurationInSeconds' => ['nullable', 'integer','min:0'],
            'dialStartTime' => ['nullable', 'date_format:Y-m-d+H:i:s'],
            'hangupCause' => ['nullable', 'string',new Enum(CallHangupCauses::class)],
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
