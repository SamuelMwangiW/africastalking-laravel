<?php

namespace SamuelMwangiW\Africastalking\Facades;

use Illuminate\Support\Facades\Facade;
use SamuelMwangiW\Africastalking\Africastalking as BaseClass;

/**
 * @see BaseClass
 * @mixin BaseClass
 */
class Africastalking extends Facade
{
    protected static function getFacadeAccessor()
    {
        return BaseClass::class;
    }
}
