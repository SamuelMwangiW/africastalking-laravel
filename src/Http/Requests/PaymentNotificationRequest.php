<?php

namespace SamuelMwangiW\Africastalking\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rules\Enum;
use SamuelMwangiW\Africastalking\Enum\Direction;
use SamuelMwangiW\Africastalking\Enum\PaymentCategory;
use SamuelMwangiW\Africastalking\Enum\PaymentProvider;
use SamuelMwangiW\Africastalking\Enum\PaymentSourceType;
use SamuelMwangiW\Africastalking\Enum\Status;
use SamuelMwangiW\Africastalking\Http\Requests\Concerns\HasUniqueId;

class PaymentNotificationRequest extends FormRequest
{
    use HasUniqueId;

    public function rules(): array
    {
        return [
            'transactionId' => ['required', 'string'],
            'category' => ['required', 'string', new Enum(PaymentCategory::class)],
            'provider' => ['required', 'string', new Enum(PaymentProvider::class)],
            'providerRefId' => ['nullable', 'string'],
            'providerChannel' => ['required', 'string'],
            'clientAccount' => ['nullable', 'string','max:64'],
            'productName' => ['required', 'string'],
            'sourceType' => ['required', 'string', new Enum(PaymentSourceType::class)],
            'source' => ['required', 'string', 'max:64'],
            'destinationType' => ['required', 'string', new Enum(PaymentSourceType::class)],
            'destination' => ['required', 'string'],
            'value' => ['required', 'string'],
            'transactionFee' => ['nullable', 'string'],
            'providerFee' => ['nullable', 'string'],
            'status' => ['required', 'string', new Enum(Status::class)],
            'description' => ['nullable', 'string'],
            'requestMetadata' => ['nullable', 'array'],
            'providerMetadata' => ['nullable', 'array'],
            'transactionDate' => ['nullable', 'string'],

            'direction' => ['nullable', 'string', new Enum(Direction::class)],
            'origin' => ['nullable', 'string'],
        ];
    }

    public function amount(): int
    {
        return intval(
            str($this->get('value'))->after(' ')->value()
        );
    }

    public function category(): ?PaymentCategory
    {
        return PaymentCategory::tryFrom($this->get('category'));
    }

    public function direction(): ?Direction
    {
        return Direction::tryFrom($this->get('direction'));
    }

    public function provider(): ?PaymentProvider
    {
        return PaymentProvider::tryFrom($this->get('provider'));
    }

    public function status(): ?Status
    {
        return Status::tryFrom($this->get('status'));
    }

    public function sourceType(): ?PaymentSourceType
    {
        return PaymentSourceType::tryFrom($this->get('sourceType'));
    }

    protected function idKey(): string
    {
        return 'transactionId';
    }
}
