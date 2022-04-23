<?php

use SamuelMwangiW\Africastalking\Africastalking as BaseClass;
use SamuelMwangiW\Africastalking\Facades\Africastalking;

if (! function_exists('africastalking')) {
    /**
     * @return BaseClass
     */
    function africastalking(): BaseClass
    {
        return Africastalking::getFacadeRoot();
    }
}
