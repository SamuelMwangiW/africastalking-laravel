<?php

namespace SamuelMwangiW\Africastalking\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use SamuelMwangiW\Africastalking\Http\Requests\Concerns\HasPhoneNumber;

class BulkSmsOptOutRequest extends FormRequest
{
    use HasPhoneNumber;

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
}
