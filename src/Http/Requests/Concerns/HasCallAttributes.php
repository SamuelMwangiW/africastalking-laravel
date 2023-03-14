<?php

declare(strict_types=1);

namespace SamuelMwangiW\Africastalking\Http\Requests\Concerns;

use Illuminate\Foundation\Http\FormRequest;

/** @mixin FormRequest */
trait HasCallAttributes
{
    public function callIsActive(): bool
    {
        return $this->boolean('isActive');
    }

    public function callIsInActive(): bool
    {
        return ! $this->boolean('isActive');
    }

    public function isWebrtcCall(): bool
    {
        return $this->filled('clientDialedNumber');
    }

    public function isRinging(): bool
    {
        return $this->string('callSessionState')->is('Ringing');
    }

    public function isSipAgentCall(): bool
    {
        return $this
            ->string('destinationNumber')
            ->endsWith('.africastalking.com');
    }
}
