<?php

namespace SamuelMwangiW\Africastalking\Transporter\Requests\Concerns;

use function config;

trait ChecksEnvironment
{
    public function isSandbox(): bool
    {
        return config('africastalking.username') === 'sandbox';
    }
}
