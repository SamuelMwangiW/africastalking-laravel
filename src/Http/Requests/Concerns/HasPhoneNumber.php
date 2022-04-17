<?php

namespace SamuelMwangiW\Africastalking\Http\Requests\Concerns;

use Illuminate\Foundation\Http\FormRequest;

/** @mixin FormRequest */
trait HasPhoneNumber
{
    public function phone(): string
    {
        return $this->get($this->phoneNumberKey());
    }

    protected function phoneNumberKey(): string
    {
        return 'phoneNumber';
    }
}
