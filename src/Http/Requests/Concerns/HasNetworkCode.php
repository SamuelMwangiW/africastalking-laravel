<?php

namespace SamuelMwangiW\Africastalking\Http\Requests\Concerns;

use Illuminate\Foundation\Http\FormRequest;
use SamuelMwangiW\Africastalking\Enum\Network;

/** @mixin FormRequest */
trait HasNetworkCode
{
    public function network(): Network
    {
        return Network::from(
            $this->get('networkCode')
        );
    }
}
