<?php

namespace SamuelMwangiW\Africastalking\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class BulkSmsOptOutRequest extends FormRequest
{
    public function rules(): array
    {
        return [
            'senderId' => ['required', 'string'],
            'phoneNumber' => ['required', 'string'],
        ];
    }

    public function id(): string
    {
        return $this->get(key: 'senderId');
    }

    public function phone(): string
    {
        return $this->get(key: 'phoneNumber');
    }
}
