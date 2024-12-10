<?php

declare(strict_types=1);

namespace SamuelMwangiW\Africastalking\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rules\Enum;
use SamuelMwangiW\Africastalking\Enum\Status;
use SamuelMwangiW\Africastalking\Http\Requests\Concerns\HasPhoneNumber;
use SamuelMwangiW\Africastalking\Http\Requests\Concerns\HasStatus;
use SamuelMwangiW\Africastalking\Http\Requests\Concerns\HasUniqueId;

class AirtimeStatusRequest extends FormRequest
{
    use HasPhoneNumber;
    use HasStatus;
    use HasUniqueId;

    public function rules(): array
    {
        return [
            'requestId' => [
                'string',
                'required',
                'min:32',
            ],
            'phoneNumber' => [
                'string',
                'required',
                'min:10',
            ],
            'description' => [
                'string',
                'required',
            ],
            'status' => [
                'string',
                'required',
                new Enum(Status::class),
            ],
            'value' => [
                'string',
                'required',
                'string',
            ],
            'discount' => [
                'string',
                'required',
                'string',
            ],
        ];
    }

    protected function idKey(): string
    {
        return 'requestId';
    }

    public function value(): string
    {
        return $this->get(key: 'value');
    }

    public function discount(): string
    {
        return $this->get(key: 'discount');
    }

    public function deliveryFailed(): bool
    {
        return in_array(
            needle: $this->get(key: 'status'),
            haystack: ['Rejected', 'Failed'],
        );
    }
}
