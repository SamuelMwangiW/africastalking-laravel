<?php

namespace SamuelMwangiW\Africastalking\Http\Requests;

use Carbon\CarbonInterval;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Support\Carbon;
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

    public function id(): string
    {
        return $this->get('sessionId');
    }

    public function phone(): string
    {
        return $this->get('phoneNumber');
    }

    public function network(): ?Network
    {
        return Network::tryFrom(
            $this->get('networkCode')
        );
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
            $this->get('durationInMillis',0)
        );
    }
}
