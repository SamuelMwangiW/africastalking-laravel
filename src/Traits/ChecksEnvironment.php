<?php

namespace SamuelMwangiW\Africastalking\Traits;

trait ChecksEnvironment
{
    public function isSandbox(): bool
    {
        return config('africastalking.username') === 'sandbox';
    }
}
