<?php

namespace SamuelMwangiW\Africastalking\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rules\Enum;
use SamuelMwangiW\Africastalking\Enum\UpdateType;
<<<<<<< HEAD
use SamuelMwangiW\Africastalking\Http\Requests\Concerns\HasPhoneNumber;

class SubscriptionRequest extends FormRequest
{
    use HasPhoneNumber;

=======

class SubscriptionRequest extends FormRequest
{
>>>>>>> 0f9d846 (Subscription Notification request)
    public function rules(): array
    {
        return [
            'phoneNumber' => ['string', 'required', 'min:10', 'max:18'],
            'shortCode' => ['string', 'required', 'min:3', 'max:18'],
            'keyword' => ['string', 'nullable', 'min:3', 'max:18'],
            'updateType' => ['string', 'required', new Enum(UpdateType::class)],
        ];
    }

<<<<<<< HEAD
=======
    public function phone(): string
    {
        return $this->get('phoneNumber');
    }

>>>>>>> 0f9d846 (Subscription Notification request)
    public function type(): UpdateType
    {
        return UpdateType::from(
            $this->get('updateType')
        );
    }
}
