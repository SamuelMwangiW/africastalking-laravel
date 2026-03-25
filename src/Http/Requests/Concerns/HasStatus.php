<?php

declare(strict_types=1);

namespace SamuelMwangiW\Africastalking\Http\Requests\Concerns;

use Illuminate\Foundation\Http\FormRequest;
use SamuelMwangiW\Africastalking\Enum\Status;

/** @mixin FormRequest */
trait HasStatus
{
    public function status(): Status|string
    {
        $status = $this->str(key: 'status')->value();

        return Status::tryFrom($status) ?? $status;
    }
}
