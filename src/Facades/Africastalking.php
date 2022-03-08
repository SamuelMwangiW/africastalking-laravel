<?php

namespace SamuelMwangiW\Africastalking\Facades;

use Illuminate\Support\Facades\Facade;

/**
 * @see \SamuelMwangiW\Africastalking\Africastalking
 */
class Africastalking extends Facade
{
    protected static function getFacadeAccessor()
    {
        return 'africastalking-laravel';
    }
}
