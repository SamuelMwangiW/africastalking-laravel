<?php

namespace SamuelMwangiW\Africastalking\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rules\Enum;
use SamuelMwangiW\Africastalking\Enum\Network;
use SamuelMwangiW\Africastalking\Enum\Status;

class UssdEventRequest extends FormRequest
{
    public function rules(): array
    {
        return [
            'date' => ['required', 'date'],
            'sessionId' => ['required', 'string'],
            'serviceCode' => ['required', 'string'],
            'phoneNumber' => ['required', 'string'],
            'networkCode' => [
                'required',
                'string',
                new Enum(type: Network::class),
            ],
            'status' => [
                'required',
                new Enum(type: Status::class),
            ],
            'cost' => ['required','numeric'],
            'durationInMillis' => ['required','integer'],
            'hopsCount' => ['required','integer'],
            'input' => ['required','string'],
            'lastAppResponse' => ['required','string'],
            'errorMessage' => ['nullable','string'],
        ];
    }
}
