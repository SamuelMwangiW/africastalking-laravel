<?php

declare(strict_types=1);

namespace SamuelMwangiW\Africastalking\Http\Requests\Concerns;

use Illuminate\Foundation\Http\FormRequest;

/** @mixin FormRequest */
trait HasPhoneNumber
{
    public function phone(): string
    {
        return $this->str($this->phoneNumberKey())->value();
    }

    protected function phoneNumberKey(): string
    {
        return 'phoneNumber';
    }
}
