<?php

namespace SamuelMwangiW\Africastalking\Http\Requests\Concerns;

use Illuminate\Foundation\Http\FormRequest;
use SamuelMwangiW\Africastalking\Enum\Status;

/** @mixin FormRequest */
trait HasStatus
{
    public function status()
    {
        return Status::tryFrom(
            $this->get('status')
        ) ?? $this->get('status');
    }
}
