<?php

declare(strict_types=1);

namespace SamuelMwangiW\Africastalking\Http\Requests\Concerns;

use Illuminate\Foundation\Http\FormRequest;

/** @mixin FormRequest */
trait HasUniqueId
{
    public function id(): string
    {
        return $this->get(
            $this->idKey()
        );
    }

    protected function idKey(): string
    {
        return 'id';
    }
}
