<?php

use SamuelMwangiW\Africastalking\Facades\Africastalking;
use SamuelMwangiW\Africastalking\Africastalking as BaseClass;

if (!function_exists('africastalking')) {
    /**
     * @return BaseClass
     */
    function africastalking(): BaseClass
    {
        return Africastalking::getFacadeRoot();
    }
}
