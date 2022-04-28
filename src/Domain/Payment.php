<?php

namespace SamuelMwangiW\Africastalking\Domain;

class Payment
{
    public function mobileCheckout(): MobileCheckout
    {
        return app(MobileCheckout::class);
    }
}
