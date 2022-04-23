<?php

namespace SamuelMwangiW\Africastalking\Http\Requests;

use Carbon\CarbonInterval;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rules\Enum;
use SamuelMwangiW\Africastalking\Enum\Network;
use SamuelMwangiW\Africastalking\Enum\Status;
use SamuelMwangiW\Africastalking\Http\Requests\Concerns\HasNetworkCode;
use SamuelMwangiW\Africastalking\Http\Requests\Concerns\HasPhoneNumber;
use SamuelMwangiW\Africastalking\Http\Requests\Concerns\HasUniqueId;

class UssdEventRequest extends FormRequest
{
    use HasNetworkCode;
    use HasPhoneNumber;
    use HasUniqueId;

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
            'input' => ['nullable','string'],
            'lastAppResponse' => ['required','string'],
            'errorMessage' => ['nullable','string'],
        ];
    }

    protected function idKey(): string
    {
        return 'sessionId';
    }

    public function userInput(): string
    {
        return $this->get('input');
    }

    public function cost(): float
    {
        return floatval($this->get('cost'));
    }

    public function hops(): int
    {
        return $this->get('hopsCount');
    }

    public function duration(): CarbonInterval
    {
        return CarbonInterval::microseconds(
            $this->get('durationInMillis', 0)
        );
    }
}
