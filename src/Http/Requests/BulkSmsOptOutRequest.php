<?php

declare(strict_types=1);

namespace SamuelMwangiW\Africastalking\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use SamuelMwangiW\Africastalking\Http\Requests\Concerns\HasPhoneNumber;
use SamuelMwangiW\Africastalking\Http\Requests\Concerns\HasUniqueId;

class BulkSmsOptOutRequest extends FormRequest
{
    use HasPhoneNumber;
    use HasUniqueId;

    public function rules(): array
    {
        return [
            'senderId' => ['required', 'string'],
            'phoneNumber' => ['required', 'string'],
        ];
    }

    protected function idKey(): string
    {
        return 'senderId';
    }
}
